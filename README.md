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
- 例子

```php
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
     * @apiDescription this is v1 demo1
     *
     * 这也是版本一演示一描述
     *
     * 这还是版本一演示一描述
     *
     * @apiParam {int} field1 field11
     * @apiParam {string} [field2] field22
     * @apiSuccessExample 成功响应:
     * {
     *     "bool": true,
     *     "msg": "提交成功"
     * }
     *
     * @apiErrorExample 失败响应:
     * {
     *   "bool": false,
     *   "msg": "提交失败"
     * }
     */
    public function demo1(Request $request)
    {
        return response()->json(['code' => 1, 'msg' => '提交成功']);
    }

    /**
     * @apiVersion 1.0.1
     * @apiGroup demos
     * @apiName v1-demos-demo2
     * @api {get} /v1/demos/demo2 v1-demo2
     * @apiDescription this is v1 demo2
     * @apiParam {string} field1 字段一
     */
    public function demo2(Request $request)
    {
        return response()->json($request->all(), 200, $headers);
    }
}
```

- browse

http://your-domain-name/apidoc

- how to customize the view?

Add the `view` key in the configuration file, for example:`'view' => 'apidoc'`, then the view file is `/resources/views/apidoc.blade.php`
