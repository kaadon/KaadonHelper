<?php
/**
 * Created by : PhpStorm
 * Web: https://developer.kaadon.com
 * User: ipioo
 * Date: 2022/1/14 22:11
 */

//PHP stdClass Object转array

if (!function_exists('kaadon_object_array')) {
    /**
     * @param $array
     * @return array|mixed
     */
    function kaadon_object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}


if (!function_exists('kaadon_strToUtf8')) {
    /**
     * 字符串转UTF8
     * @param $str
     * @return array|false|mixed|string
     */
    function strToUtf8($str)
    {
        $encode = mb_detect_encoding($str, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
        if ($encode == 'UTF-8') {
            return $str;
        } else {
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }
}

if (!function_exists("kaadon_bcMath")) {
    /**
     * 常用数学函数 + - * /
     * @param string|int|float $first
     * @param string|int|float $second
     * @param string $type
     * @param int $pointNum
     * @return string
     */
    function bcMath(string|int|float $first, string|int|float $second, string $type = '-', int $pointNum = 8): string
    {
        $first = number_format(floatval($first), $pointNum, '.', '');
        $second = number_format(floatval($second), $pointNum, '.', '');
        switch ($type) {
            case '-':
                return bcsub($first, $second, $pointNum);
                break;
            case '+':
                return bcadd($first, $second, $pointNum);
                break;
            case '/':
                return bcdiv($first, $second, $pointNum);
                break;
            case '*':
                return bcmul($first, $second, $pointNum);
                break;
            default :
                return "0";
        }
    }


    if (!function_exists("datetime")) {
        /**
         * 时间
         * @return string
         */
        function datetime()
        {
            return date('Y-m-d H:i:s', time());
        }
    }

}


if (!function_exists('kaadon_random_str')) {
    /**
     * 随机字符串
     * @param int $len
     * @param bool $special
     * @return string
     */
    function kaadon_random_str(int $len, bool $special = false): string
    {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
        );

        if ($special) {
            $chars = array_merge($chars, array(
                "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
                "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
                "}", "<", ">", "~", "+", "=", ",", "."
            ));
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }
}

if (!function_exists("isBTCAddress")) {
    /**
     * 判断BTC地址
     *
     * @param $value
     * @return bool
     */
    function isBTCAddress($value)
    {
        // BTC地址合法校验33/34
        if (!(preg_match('/^(1|3|2)[a-zA-Z\d]{24,36}$/', $value) && preg_match('/^[^0OlI]{25,36}$/', $value))) {
            return false; //满足if代表地址不合法
        }
        return true;
    }

}

if (!function_exists("isETHAddress")) {
    /**
     * 判断ETH地址
     *
     * @param $value
     * @return bool
     */
    function isETHAddress($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]{40}$/', $value) >= 1);
    }
}


