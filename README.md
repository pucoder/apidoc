# laravel and lumen api document package

[Documentation](http://apidoc.pudejun..com/) and [Example](http://apidoc.pudejun.com/apidoc/)

# Installation

```shell script
composer require pucoder/apidoc
```

## Usage

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

Add some apidoc comments anywhere in your source code:

```php
/**
 * @apiVersion 1.0.1
 * @apiGroup Users
 * @apiName v1-getUser
 * @api get /v1/users/getUser Request User information
 * @apiDescription Pass api_token in request header to get user information
 * @apiHeader string Authorization User authorization credentials
 * @apiHeaderExample request header example:
 * {
 *   "Authorization":"Bearer ......"
 * }
 */
```

- browse

http://your-domain-name/apidoc