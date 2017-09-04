<?php

namespace Pletfix\Hello\Commands;

use Core\Services\Command;

class HelloCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hello:greeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Say Hello!';

    /**
     * Possible arguments of the command.
     *
     * @var array
     */
    protected $arguments = [
        'name' => ['type' => 'string', 'default' => 'nobody', 'description' => 'Your name'],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('Hello' . $this->input('name'));
    }
}