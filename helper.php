<?php
/**
 * Created by : PhpStorm
 * Web: https://developer.kaadon.com
 * User: kaadon.com
 * Date: 2022/1/14 22:11
 */

//PHP ARRAY 相关
if (!function_exists('array_rand_value')) {
    /**
     * 数组随机取值
     *
     * @param array $array
     * @param int $num
     *
     * @return mixed
     */
    function array_rand_value(array $array, int $num = 1): mixed
    {
        if ($num == 0) return null;
        $array_count = count($array);
        if ($array_count == 1) return $array[array_keys($array)[0]];
        if ($num >= $array_count) {
            return $array;
        }
        $value = null;
        $array_rand = array_rand($array, $num);
        if ($num == 1) {
            $value = $array[$array_rand];
        } else {
            foreach ($array_rand as $item) {
                $value[] = $array[$item];
            }
        }
        return $value;
    }
}
if (!function_exists('object_array')) {
    /**
     * OBJECT TO ARRAY
     *
     * @param array|object $array
     *
     * @return array
     */
    function object_array(array|object $array): array
    {
        if (is_object($array)) {
            $array = (array)$array;
        } elseif (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $array[$key] = object_array($value);
                } else {
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }
}
if (!function_exists('line_array')) {
    /**
     * @param string $str 待分割字符串
     * @param string $separator 分割字符串
     * @param bool $reverse 是否反序
     *
     * @return array
     */
    function line_array(string $str, string $separator = ',', bool $reverse = false): array
    {
        $strArray = explode($separator, $str);
        foreach ($strArray as $key => $item) {
            if (empty($item)) {
                unset($strArray[$key]);
            }
        }
        if ($reverse) {
            $strArray = array_reverse($strArray);
        }
        return $strArray;
    }
}
/* YACONF */
if (!function_exists('get_yaconf_config')) {
    /**
     * @param string $group 文件中 [分组名]
     * @param string|null $name 配置名
     * @param string $fileName yaconf目录下 app.ini
     *
     * @return array|string|int|float|bool
     */
    function get_yaconf_config(string $group, ?string $name = null, string $fileName = "app"): array|string|int|float|bool
    {
        $path = "{$fileName}.{$group}";
        if (!is_null($name)) $path .= ".{$name}";
        return \Yaconf::get($path);
    }
}
/* string相关 */
if (!function_exists('strToUtf8')) {
    /**
     * 字符串转UTF8
     * @param $str
     * @return array|false|mixed|string
     */
    function strToUtf8($str): mixed
    {
        $encode = mb_detect_encoding($str, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
        if ($encode == 'UTF-8') {
            return $str;
        } else {
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }
}
if (!function_exists('random_str')) {
    /**
     * 随机字符串
     * @param int $len
     * @param bool $special
     * @return string
     */
    function random_str(int $len, bool $special = false): string
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
/* 时间相关 */
if (!function_exists("datetime")) {
    /**
     * 时间
     * @param int|null $time
     * @return string
     */
    function datetime(?int $time): string
    {
        if (empty($time)) $time = time();
        return date('Y-m-d H:i:s', $time);
    }
}
/* 数学相关 */
if (!function_exists("bcMath")) {
    /**
     * 常用数学函数 + - * /
     * @param string|int|float $first
     * @param string $type
     * @param string|int|float $second
     * @param int $pointNum
     * @return string|null
     */
    function bcMath(string|int|float $first, string $type, string|int|float $second, int $pointNum = 8): string|null
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
                return null;
        }
    }

}
//PHP BLOCKCHAIN 相关
if (!function_exists("isBTCAddress")) {
    /**
     * 判断BTC地址
     *
     * @param $value
     * @return bool
     */
    function isBTCAddress($value): bool
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
    function isETHAddress($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        return (preg_match('/^0x[a-fA-F0-9]{40}$/', $value) >= 1);
    }
}


