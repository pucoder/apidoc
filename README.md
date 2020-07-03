
# install package

```shell script
composer require pucoder/apidoc
```

# Instructions

- lumen 

```shell
# Register Service Providers in bootstrap/app.php
$app->register(Pucoder\Apidoc\ApiDocServiceProvider::class);

# run command
php artisan apidoc:publish

# Register Config Files in bootstrap/app.php
$app->configure('apidoc');

# open view function
$app->withFacades();
```

- laravel

```shell
# run command
php artisan apidoc:publish
```

> Please make relevant configuration in `config/apidoc.php` file before use

- browse

http://your-domain-name/apidoc

- how to customize the view?

Add the `view` key in the configuration file, for example:`'view' => 'apidoc'`, then the view file is `/resources/views/apidoc.blade.php`
