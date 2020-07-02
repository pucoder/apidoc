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
php artisan apidoc:publish --provider="Pucoder\Apidoc\ApiDocServiceProvider"
```
- laravel
```shell
# run command
php artisan apidoc:publish --provider="Pucoder\Apidoc\ApiDocServiceProvider"
```

> Please make relevant configuration in `config/apidoc.php` file before use

- controller annotation example

```php
<?php
namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * @apiVersion 1.0.1
     * @apiGroup demos
     * @apiName v1-demos-demo1
     * @api {post} /v1/demos/demo1 v1-demo1
     * @apiDescription this is v1-demo1
     *
     * this is also v1-demo1
     *
     * this is still v1-demo1
     *
     * @apiParam {int} age User's age
     * @apiParam {string} name User's name
     * @apiParam {bool} [gender] User's gender
     * @apiParam {json} [intro] User's intro
     * @apiParam {file} [avatar] User's avatar
     * @apiParamExample successful response:
     * {
     *     "bool": true,
     *     "msg": "submitted successfully"
     *     "data": {
     *         "age": 18,
     *         "name": david,
     *         "gender": true,
     *     }
     * }
     * @apiSuccessExample successful response:
     * {
     *     "bool": true,
     *     "msg": "submitted successfully"
     * }
     */
    public function demo1(Request $request)
    {
        $data = $request->all();
        return response()->json(['bool' => true, 'msg' => 'submitted successfully', 'data' => $data]);
    }

    /**
     * @apiVersion 1.0.1
     * @apiGroup demos
     * @apiName v1-demos-demo2
     * @api {get} /v1/demos/demo2 v1-demo2
     * @apiDescription this is v1-demo2
     *
     * @apiHeader {string} Authorization User authorization credentials
     * @apiHeaderExample request header example:
     * {
     *   "Authorization":"lots of strings"
     * }
     * @apiErrorExample failure response:
     * {
     *   "bool": false,
     *   "msg": "submission failed"
     * }
     */
    public function demo2(Request $request)
    {
        return response()->json(['bool' => false, 'msg' => 'submission failed']);
    }
}
```

- browse

http://your-domain-name/apidoc

- how to customize the view?

Add the `view` key in the configuration file, for example:`'view' => 'apidoc'`, then the view file is `/resources/views/apidoc.blade.php`
