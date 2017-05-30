<?php

namespace Pletfix\Hello\Auth;

//use Core\Services\AbstractAuth;
use Core\Services\Contracts\Auth as AuthContract;
use Exception;

//class Db extends AbstractAuth
class Custom implements AuthContract
{
    /**
     * Connection Settings
     *
     * @var array
     */
    protected $config;

    /**
     * Attributes of the current user.
     *
     * It's null if the attributes do not loaded from the session yet.
     *
     * @var array|null
     */
    protected $attributes = null;

    /**
     * Create a new Auth instance.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        // set default configuration
        $this->config = array_merge([
            'config_key' => 'hello.accounts',
            'identity'   => 'email',
        ], $config);

//        // set default configuration
//        parent::__construct(array_merge([
//            'file' => config_path('credentials.php'),
//        ], $config));
    }

    /**
     * @inheritdoc
     */
    public function login(array $credentials)
    {
        $field = $this->config['identity']; // usually "email" or "name"
        $value = $credentials[$field];
        $account = $this->findAccount($field, $value);
        if ($account === null) {
            return false;
        }

        $password = $credentials['password'];
        if (!password_verify($password, $account['password'])) {
            return false;
        }

        $this->setPrincipal($account['id'], $account['name'], $account['role']);

        // If the user should be permanently "remembered" by the application we will create a "remember me" cookie.
        if (!empty($credentials['remember'])) {
            $this->saveRememberMeCookie($account['id'], $account['token']);
        }
        else {
            $this->deleteRememberMeCookie();
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function logout()
    {
        session()
            ->delete('_auth')
            ->delete('_csrf_token')
            ->regenerate();
        $this->deleteRememberMeCookie();
        $this->attributes = [];
    }

    private function findAccount($key, $value)
    {
        $list = config($this->config['config_key']);
        foreach ($list as $item) {
            if ($item[$key] === $value) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Create a "remember me" cookie.
     *
     * @param int $id User ID
     * @param string $token The "remember me" token. Could be created with random_string(60).
     */
    protected function saveRememberMeCookie($id, $token)
    {
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/'); // PHP_SELF = /myapp/public/index.php

        // Create a cookie that lasts "forever" (five years).
        cookie()->set('remember_me', base64_encode($id . '|' . $token), 2628000, $path);
    }

    /**
     * Delete the "remember me" cookie for a given ID.
     */
    protected function deleteRememberMeCookie()
    {
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/');

        cookie()->delete('remember_me', $path); // Path anpassen
    }

    /**
     * Read the "remember me" cookie if exist and store the principal into the session.
     */
    protected function loadPrincipalFromRememberMeCookie()
    {
        $hash = cookie('remember_me');
        if ($hash === null) {
            return;
        }

        try {
            list($id, $token) = explode('|', base64_decode($hash));
        }
        catch (Exception $e) {
            $this->deleteRememberMeCookie();
            return;
        }

        $this->loadPrincipalFromRememberMeToken($id, $token);
    }

    /**
     * Load the user principal by given id and token.
     *
     * @param int $id
     * @param string $token
     */
    protected function loadPrincipalFromRememberMeToken($id, $token)
    {
        $account = $this->findAccount('id', $id);
        if ($account !== null && $token === $account['token']) {
            $this->setPrincipal($account['id'], $account['name'], $account['role']);
        }
    }

    /**
     * Set the attributes of the principal and store it in the session.
     *
     * @param int $id
     * @param string $name
     * @param string $role
     */
    protected function setPrincipal($id, $name, $role)
    {
        $this->attributes = [
            'id'        => $id,
            'name'      => $name,
            'role'      => $role,
            'abilities' => $this->getAbilities($role),
        ];

        session()->set('_auth', $this->attributes);
    }

    /**
     * Read the abilities from the ACL for the given role.
     *
     * @param $role
     * @return array
     */
    protected function getAbilities($role)
    {
        $abilities = [];
        foreach (config('auth.acl') as $ability => $roles) {
            if (in_array($role, $roles)) {
                $abilities[] = $ability;
            }
        }

        return $abilities;
    }

    /**
     * Load the user attributes from the session and get the attribute.
     *
     * @param string $key
     * @return mixed
     */
    protected function attribute($key)
    {
        if ($this->attributes === null) {
            $this->attributes = session('_auth', []);
            if (empty($this->attributes)) {
                $this->loadPrincipalFromRememberMeCookie();
            }
        }

        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    /**
     * @inheritdoc
     */
    public function isVerified() // or check? or isValid? or ...?
    {
        return $this->attribute('id') !== null;
    }

    /**
     * @inheritdoc
     */
    public function id()
    {
        return $this->attribute('id');
    }

    /**
     * @inheritdoc
     */
    public function name()
    {
        return $this->attribute('name');
    }

    /**
     * @inheritdoc
     */
    public function role()
    {
        return $this->attribute('role');
    }

    /**
     * @inheritdoc
     */
    public function abilities()
    {
        return $this->attribute('abilities');
    }

    /**
     * @inheritdoc
     */
    public function is($role)
    {
        return $this->role() === $role;
    }

    /**
     * @inheritdoc
     */
    public function can($ability)
    {
        return in_array($ability, $this->abilities() ?: []);
    }

    /**
     * Change the display name of the current user.
     *
     * @param string $name
     */
    public function changeName($name)
    {
        if ($this->isVerified() && $this->name() !== $name) {
            $this->setPrincipal($this->id(), $name, $this->role());
        }
    }

    /**
     * Change the role of the current user.
     *
     * @param string $role
     */
    public function changeRole($role)
    {
        if ($this->isVerified() && $this->role() !== $role) {
            $this->setPrincipal($this->id(), $this->name(), $role);
            session()
                ->delete('_csrf_token')
                ->regenerate();
        }
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name();
    }
}