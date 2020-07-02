<?php


namespace Pucoder\Apidoc\Controller;

use App\Http\Controllers\Controller;

class ApiDocController extends Controller
{
    public function index()
    {
        $dir = base_path(config('apidoc.dir'));
        $except_folders = config('apidoc.except_folders');
        $except_files = config('apidoc.except_files');
        $lang = config('apidoc.lang') ?: 'en';
        $local = config('apidoc.local');

        $file_paths = $this->getFilesPath($dir, $except_folders, $except_files);

        $datas = [];
        foreach ($file_paths as $file_path) {
            $jsons = $this->getFileDocment($file_path);
            foreach ($jsons as $json) {
                array_push($datas, $json);
            }
        }

        // 获取apiGroup的值
        $api_group = array_column($datas, 'apiGroup');
        // 去重
        $groups = array_unique($api_group);
        // 排序
        sort($groups);

        $view = config('apidoc.view') ?: 'apidoc::index';

        $data = [
            'title' => config('apidoc.title'),
            'name' => config('apidoc.name'),
            'description' => config('apidoc.description'),
            'lang' => $lang,
            'local' => $local,
            'groups' => $groups,
            'datas' => $datas
        ];

//        return response()->json($datas);
        return view($view, $data);
    }

    /**
     * 获取需要编译文档的类文件路径
     *
     * @param $dir
     * @param $except_folders
     * @param $except_files
     * @return array
     */
    protected function getFilesPath($dir, $except_folders, $except_files)
    {
        static $file_lists = [];

        $files=scandir($dir);

        foreach ($files as $file) {
            if($file != '.' && $file != '..') {
                if(is_file($dir. '/' . $file)){
                    // 排除非php文件和例外的文件
                    if (pathinfo($file)['extension'] === 'php' && !in_array($file, $except_files)) {
                        $path = $dir. '/' . $file;
                        $path = str_replace(base_path(), '', $path);
                        $path = str_replace('.php', '', $path);
                        $path = ltrim($path, '/');
                        $path = str_replace('/', '\\', $path);
                        array_push($file_lists, $path);
                    }
                } else {
                    // 排除例外目录
                    if (!in_array($file, $except_folders)) {
                        $this->getFilesPath($dir. '/' . $file, $except_folders, $except_files);
                    }
                }
            }
        }

        return $file_lists;
    }

    protected function getFileDocment($path)
    {
        $reflection = new \ReflectionClass($path);

        $reflection_methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        $methods = [];
        foreach ($reflection_methods as $reflection_method) {
            if ($reflection_method->getDeclaringClass()->getName() === $path) {
                array_push($methods, $reflection_method->getName());
            }
        }

        $documents = [];
        foreach ($methods as $method) {
            $method = $reflection->getMethod($method);
            array_push($documents, $method->getDocComment());
        }

        $array_documents = [];
        foreach ($documents as $document) {
            if (strpos($document, '@api') !== false) {
                $document = str_replace(["/**\n     * @", "\n     */"], ['',''], $document);
                array_push($array_documents, explode("\n     * @", $document));
            }
        }

        $json_documents = [];
        foreach ($array_documents as $array_document) {
            array_push($json_documents, $this->setJson($array_document));
        }

        return $json_documents;
    }

    protected function setJson($documents)
    {
        $json = [];
        $params = [];
        $headers = [];
        foreach ($documents as $document) {
            // 第一个空格的位置
            $first = mb_stripos($document, " ");
            $key = mb_substr($document, 0, $first);
            $value = mb_substr($document, $first + 1);

            // 处理描述
            if ($key === 'apiDescription') {
                $value = str_replace("\n     * ", "<br>", $value);
                $value = str_replace("\n     *", "", $value);
            }

            // 处理示例
            if (in_array($key, ['apiHeaderExample', 'apiParamExample', 'apiSuccessExample', 'apiErrorExample'])) {
                $value = str_replace("\n     * ", "", $value);
                $value = str_replace("\n ", "", $value);
                $value = str_replace("*", "", $value);
                $value = str_replace(": ", ":", $value);
                $first = mb_stripos($value, ":");
                $value = [mb_substr($value, 0, $first), mb_substr($value, $first + 1)];
            }

            // 处理接口
            if ($key === 'api') {
                $items = explode(" ", $value);
                $json['apiType'] = rtrim(ltrim($items[0], '{'), "}");
                $json['apiUrl'] = $items[1];
                $json['apiTitle'] = $items[2];
            }
            // 处理请求头
            elseif ($key === 'apiHeader') {
                $value = str_replace("\n     *", "", $value);
                $param = explode(" ", $value);
                $item['description'] = '';
                foreach ($param as $key => $value) {
                    if ($key === 0) {
                        $item['type'] = rtrim(ltrim($value, '{'), "}");
                    } elseif ($key === 1) {
                        if (strpos($value, '[') !== false) {
                            $item['field'] = rtrim(ltrim($value, '['), "]");
                            $item['optional'] = true;
                        } else {
                            $item['field'] = $value;
                            $item['optional'] = false;
                        }
                    } else {
                        $item['description'] .= $value . ' ';
                    }
                }
                $item['description'] = rtrim($item['description'], " ");
                array_push($headers, $item);
            }
            // 处理参数
            elseif ($key === 'apiParam') {
                $value = str_replace("\n     *", "", $value);
                $param = explode(" ", $value);
                $item['description'] = '';
                foreach ($param as $key => $value) {
                    if ($key === 0) {
                        $item['type'] = rtrim(ltrim($value, '{'), "}");
                    } elseif ($key === 1) {
                        if (strpos($value, '[') !== false) {
                            $item['field'] = rtrim(ltrim($value, '['), "]");
                            $item['optional'] = true;
                        } else {
                            $item['field'] = $value;
                            $item['optional'] = false;
                        }
                    } else {
                        $item['description'] .= $value . ' ';
                    }
                }
                $item['description'] = rtrim($item['description'], " ");
                array_push($params, $item);
            } else {
                $json[$key] = $value;
            }
        }
        $json['apiHeaders'] = $headers;
        $json['apiParams'] = $params;

        return $json;
    }

}