# A Pletfix Plugin Example.

## About This

This is just a plugin that shows the possibilities of the Pletfix plugin system. You can also use it as a template for 
the development of new plugins.

Read more about Pletfix in the [official documentation](https://pletfix.com).

## Plugin Development

If you want to write your own plugin, you should create a workbench as follows.

1. Install a fresh [Pletfix Application](https://github.com/pletfix/app)

2. Create a folder `workbench` under the project folder, download this plugin example and stored it under the name as 
   you wish. After then the `workbench` folder looks like this:
   
    ~~~    
    |-your-app  
        |-workbench/
           |-your-vendor-name/
              |-your-plugin-name/
                 |-assets/
                 |-config/
                 |-lang/
                 |-migrations/
                 |-src/
                 |-tests/
                 |-.gitignore
                 |-composer.json
                 |-README.md

    ~~~    

3. For auto loading the plugin, add a `psr-4` directive into the application's `composer.json`:
        
    ~~~    
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Your-Namespace\\": "workbench/your-vendor-name/your-plugin-name/src/"
        }
    }  
    ~~~

    By convention, the namespace should consist of vendor and plugin name. The vendor name should be your username 
    or organization name of your github account.
    
    Now you are ready to add services, assets, commands or what ever you like. 

Read more about writing Pletfix plugins in the [official documentation](https://pletfix.com/docs/master/en/plugins#writing).   

> Don't forget to add a entry on the [Pletfix plugin page](https://pletfix.com/plugins) when you finish your plugin.
