<?php

if (! function_exists('strs_str_num')) {

    /**
     * 获取字符串第几个指定字符前后的字符串
     *
     * @param $strs
     * @param $str
     * @param int $num
     * @return array
     */
    function strs_str_num($strs, $str, $num = 1)
    {
        $string = $strs;
        $index = 0;
        for ($i = 1; $i <= $num; $i++) {
            $index += mb_stripos($string, $str);
            $string = mb_substr($string, $index + 1);
        }

        return [mb_substr($strs, 0, $index), mb_substr($strs, $index + 1)];
    }
}
