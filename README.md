# install package

```shell script
composer require pucoder/apidoc
```

# Instructions

- lumen 
  ```shell
  # registration service in bootstrap/app.php
  $app->register(Pucoder\Apidoc\ApiDocServiceProvider::class);

  # run command
  php artisan vendor:publish --provider="Pucoder\Apidoc\ApiDocServiceProvider"
  ```
- laravel
  ```shell
  # run command
  php artisan vendor:publish --provider="Pucoder\Apidoc\ApiDocServiceProvider"
  ```
- browse

  http://your-domain-name/apidoc

- how to customize the view?

  Add the `view` key in the configuration file, for example:`'view' => 'apidoc'`, then the view file is `/resources/views/apidoc.blade.php`
