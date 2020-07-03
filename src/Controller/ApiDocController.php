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

    /**
     * 获取一个类中公共方法的注释（数组）
     *
     * @param $path
     * @return array
     * @throws \ReflectionException
     */
    protected function getFileDocment($path)
    {
        // 获取需要的类
        $reflection = new \ReflectionClass($path);

        // 获取类和关联类的所有公共方法名和方法所属类
        $reflection_methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        // 获取所有需要的方法名
        $methods = $this->getMethods($reflection_methods, $path);

        // 获取所有方法名的注释（字符串）
        $string_documents = $this->getDocuments($methods, $reflection);

        // 获取所有方法名的注释（数组）
        $array_documents = $this->getDocumentsArray($string_documents);

        // 获取所有方法的注释（处理后的数组）
        $json_documents = $this->getDocumentsJson($array_documents);

        return $json_documents;
    }

    /**
     * 获取公共方法
     *
     * @param $reflection_methods
     * @param $path
     * @return array
     */
    protected function getMethods($reflection_methods, $path)
    {
        $methods = [];

        foreach ($reflection_methods as $reflection_method) {
            if ($reflection_method->getDeclaringClass()->getName() === $path) {
                array_push($methods, $reflection_method->getName());
            }
        }

        return $methods;
    }

    /**
     * 获取公共方法的注释（字符串）
     *
     * @param $methods
     * @param $reflection
     * @return array
     */
    protected function getDocuments($methods, $reflection)
    {
        $documents = [];

        foreach ($methods as $method) {
            $method = $reflection->getMethod($method);
            array_push($documents, $method->getDocComment());
        }

        return $documents;
    }

    /**
     * 获取公共方法的注释（数组）
     *
     * @param $documents
     * @return array
     */
    protected function getDocumentsArray($string_documents)
    {
        $array_documents = [];

        foreach ($string_documents as $string_document) {
            if (strpos($string_document, '@api') !== false) {
                $string_document = str_replace(["/**", "*/"], ['',''], $string_document);
                $string_document = str_replace("\n     ", '', $string_document);
                array_push($array_documents, explode("* @", $string_document));
            }
        }

        return $array_documents;
    }

    protected function getDocumentsJson($array_documents)
    {
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
        $sample_request = false;
        foreach ($documents as $document) {
            // 第一个空格的位置
            $first = mb_stripos($document, " ");
            $key = mb_substr($document, 0, $first);
            $value = mb_substr($document, $first + 1);

            // 处理描述
            if ($key === 'apiDescription') {
                $value = str_replace("* ", "<br>", $value);
            }

            // 处理示例
            if (mb_strpos($key, 'Example') !== false) {
                $value = str_replace("* ", "", $value);
                $first = mb_stripos($value, ":");
                $value = [mb_substr($value, 0, $first), mb_substr($value, $first + 1)];
            }

            $value = str_replace("*", "", $value);

            // 处理接口
            if ($key === 'api') {
                $items = explode(" ", $value);
                $json['apiTitle'] = '';
                foreach ($items as $key => $value) {
                    if ($key === 0) {
                        $json['apiType'] = rtrim(ltrim($value, '{'), "}");
                    } elseif ($key === 1) {
                        $json['apiUrl'] = $value;
                    } else {
                        $json['apiTitle'] .= $value . ' ';
                    }
                }
            }
            // 处理请求头
            elseif ($key === 'apiHeader') {
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
            } elseif ($key === 'apiSampleRequest') {
                $sample_request = ($value === 'true');
            } else {
                $json[$key] = $value;
            }
        }
        $json['apiSampleRequest'] = $sample_request;
        $json['apiHeaders'] = $headers;
        $json['apiParams'] = $params;

        return $json;
    }

}
