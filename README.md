- install apidoc

```shell script
npm install apidoc -g
# project directory must configure apidoc.json
# detailed configuration please refer to https://apidocjs.com/
```

- install package

```shell script
composer require pucoder/apidoc
```

- copy shell script file

Copy `vendor/pucoder/apidoc/src/apidoc.sh` to the project directory

Modify the owner of `apidoc.sh` to be a linux user with executable permissions

- registration service

```shell script
# lumen 
# in bootstrap/app.php
$app->register(Pucoder\Apidoc\DocumentServiceProvider::class);

# laravel
# run command
php artisan vendor:publish --provider="Pucoder\Apidoc\DocumentServiceProvider"
```

- start visit

the request path is `http://your-domain_name/api-doc`