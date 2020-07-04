<?php

if (! function_exists('strs_num_str')) {
    /**
     * 获取字符串第几个指定字符前后的字符串
     *
     * @param $strs
     * @param int $num
     * @param $str
     * @return array
     */
    function strs_num_str($strs, $num = 1, $str)
    {
        $string = $strs;
        $indexs = 0;
        for ($i = 1; $i <= $num; $i++) {
            $index = mb_stripos($string, $str);
            $string = mb_substr($string, $index + 1);
            $indexs += $index + 1;
        }

        return [mb_substr($strs, 0, $indexs - 1), mb_substr($strs, $indexs)];
    }
}

if (! function_exists('strs_between')) {
    /**
     * 获取两个字符之间的字符串
     *
     * @param $strs
     * @param $start_str
     * @param $end_str
     * @param int $for_num
     * @param string $symbol
     * @return string
     */
    function strs_between($strs, $start_str, $end_str, $for_num = 0, $symbol = "-")
    {
        $switch = false;
        $string = '';
        $index = 0;

        for($i = 0; $i < strlen($strs); $i++){
            if (!$switch && substr($strs,$i,1) === $start_str) {
                $switch = true;
                $index ++;
                continue;
            }
            if ($switch && substr($strs,$i,1) === $end_str) {
                $switch = false;
                if ($for_num && $index === $for_num) {
                    break;
                }
                $string .= $symbol;
            }
            if ($switch) {
                $string .= substr($strs,$i,1);
            }
        }

        return rtrim($string, $symbol);
    }
}

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}
