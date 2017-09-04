# A Pletfix Plugin Example

## About This

This is just a plugin that shows the possibilities of the Pletfix plugin system. You can also use it as a template for 
the development of new plugins.

Read more about Pletfix in the [official documentation](https://pletfix.com).

## Plugin Development

If you want to write your own plugin, you should create a workbench as follows:

1. Install a fresh [Pletfix Application](https://github.com/pletfix/app)

2. Create a folder `workbench` under the project folder, download this plugin example and store it under the name as 
   you wish. After then the `workbench` folder looks like this:
   
    ~~~    
    |-my-app  
        |-workbench/
           |-my-vendor/
              |-my-plugin/
                 |-assets/
                 |-config/
                 |-lang/
                 |-migrations/
                 |-src/
                 |-tests/
                 |-.gitignore
                 |-composer.json
                 |-phpunit.xml.dist
                 |-README.md

    ~~~    

    The folder `my-vendor` should be named like your username or organisation name of your GitHub account, but
    in lower case with "-" as separator. The name of the plugin should also be written in lower case with "-" as separator.

3. For auto loading the plugin, add a `psr-4` directive into the application's `composer.json`:
        
    ~~~    
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "My-Namespace\\": "workbench/my-vendor/my-plugin/src/"
        }
    }  
    ~~~

    By convention, the namespace `My-Namespace` should consist of vendor and plugin name, of course in CamelCase. 
    The vendor name should be your username or organization name of your GitHub account.
    
4. After you have modified the application's `composer.json`, you have to enter the following command into a terminal 
   under the directory of your apllicaction:
    
    ~~~ 
    composer dump
    ~~~ 
    
Now you are ready to add services, assets, commands or what ever you like. 

Read more about writing Pletfix plugins in the [official documentation](https://pletfix.com/docs/master/en/plugins#writing).   

## Deploying

When you have finished your plugin, you can upload it on [Packagist](https://packagist.org/) to share with the community.
Do not forget to set the hash tag "Pletfix" so that the Plugin is automatically listed on the [Pletfix plugin page](https://pletfix.com/plugins).
