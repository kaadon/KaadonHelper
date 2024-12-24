<?php
/**
 * Created by : PhpStorm
 * Web: https://developer.kaadon.com
 * User: kaadon.com
 * Date: 2022/1/14 22:11
 */

//PHP ARRAY 相关
use Kaadon\Test\GdImageHelper;
use Kaadon\Test\FFMpegVideoHelper;

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
        return array_values($strArray);
    }
}
if (!function_exists('stdClassIsEmpty')){
    /**
     * 判断对象是否为空
     * @param stdClass $object
     * @return bool
     */
    function stdClassIsEmpty(stdClass $object): bool {
        return empty((array) $object);
    }
}

if (!function_exists('arrayIteratorIsEmpty')){
    /**
     * 判断数组是否为空
     * @param ArrayIterator $iterator
     * @return bool
     */
    function arrayIteratorIsEmpty(ArrayIterator $iterator): bool {
        return empty(iterator_to_array($iterator));
    }
}

if (!function_exists('splObjectStorageIsEmpty')){
    /**
     * 判断对象是否为空
     * @param SplObjectStorage $storage
     * @return bool
     */
    function splObjectStorageIsEmpty(SplObjectStorage $storage): bool {
        return $storage->count() === 0;
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
        /** @noinspection PhpUndefinedClassInspection */
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
            case '+':
                return bcadd($first, $second, $pointNum);
            case '/':
                return bcdiv($first, $second, $pointNum);
            case '*':
                return bcmul($first, $second, $pointNum);
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
        if (!(preg_match('/^([132])[a-zA-Z\d]{24,36}$/', $value) && preg_match('/^[^0OlI]{25,36}$/', $value))) {
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


/** http **/

if (!function_exists("sendRequest")) {
    /**
     * @param string $method
     * @param string $url
     * @param array|null $data
     * @param int $contentType
     * @param array $headers
     * @param int $timeout
     * @return object
     */
    function sendRequest(string $method, string $url, ?array $data, int $contentType = 1 ,array $headers = [], int $timeout = 30): object
    {
        if (in_array($contentType, [1, 2, 3])) {
            $contentTypeArr = [1 => "multipart/form-data", 2 => "application/json", 3 => "application/x-www-form-urlencoded"];
            $contentType = $contentTypeArr[$contentType];
        }
        // 创建一个 cURL 资源
        $curl = curl_init($url);
        // 判断是否为 HTTPS 请求
        if (stripos($url, "https://") !== false) {
            // 设置 SSL 选项
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 不验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 不验证主机名
            curl_setopt($curl, CURLOPT_SSLVERSION, 1); // 使用 TLSv1 协议
        }
        // 根据请求方法设置 cURL 选项
        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            case 'GET':
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case 'PUT':
                $contentType = 'application/json';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case 'DELETE':
                $contentType = 'application/json';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        // 设置 cURL 选项
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        // 设置请求头
        $headers[] = 'Content-Type: ' . $contentType;
        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        // 根据编码格式设置请求参数
        if ($data !== null) {
            if ($contentType == 'application/json') {
                $postData = json_encode($data);
            } elseif ($contentType == 'multipart/form-data') {
                $postData = $data;
            } else {
                $postData = http_build_query($data);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }
        // 发送请求并获取响应
        $response = curl_exec($curl);
        // 检查是否有错误发生
        if ($response === false) {
            $error = curl_error($curl);
            $result = (object)[
                'status' => false,
                'response' => $error,
            ];
        } else {
            $result = (object)[
                'status' => true,
                'response' => $response,
            ];
            // 处理响应数据
        }
        // 关闭 cURL 资源
        curl_close($curl);
        // 返回响应数据
        return $result;
    }
}
if (!function_exists("http_get")) {
    /**
     * @param string $url
     * @param array $params
     * @return object
     */
    function http_get(string $url, array $params = []): object
    {
        return sendRequest('GET', $url,$params);
    }
}
if (!function_exists("http_put")) {
    /**
     * @param string $url
     * @param array $params
     * @return object
     */
    function http_put(string $url, array $params = []): object
    {
       return sendRequest('PUT', $url,$params);
    }
}
if (!function_exists("http_post")) {
    /**
     * @param $url
     * @param array $data
     * @param array $headers
     * @param int $contentType
     * @return object
     */
    function http_post($url, array $data = [], array $headers = [],int $contentType = 1): object
    {
        return sendRequest('POST', $url, $data, $contentType, $headers, 60);
    }
}
if (!function_exists("http_delete")) {
    /**
     * @param string $url
     * @param array $params
     * @return object
     */
    function http_delete(string $url, array $params = []): object
    {
        return sendRequest('DELETE', $url,$params);
    }
}

if (!function_exists("videoTo")) {
    /**
     * @param string $videoPath
     * @param string $thumbnailPath
     * @param string $format
     * @return string
     * @throws \Kaadon\Test\HelperException
     */
    function videoTo(string $videoPath, string $thumbnailPath, string $format = 'mp4'): string
    {
        return (new FFMpegVideoHelper($videoPath))->convertTo($thumbnailPath,$format);
    }

}
if (!function_exists("videoToThumbnail")) {
    /**
     * @param $videoPath
     * @param $thumbnailPath
     * @return string
     * @throws \Kaadon\Test\HelperException
     */
    function videoToThumbnail($videoPath, $thumbnailPath): string
    {
        return (new FFMpegVideoHelper($videoPath))->toThumbnail($thumbnailPath);
    }
}



if (!function_exists("imageTo")) {
    /**
     * @param $imagePath
     * @param $webpPath
     * @return string
     * @throws \Kaadon\Test\HelperException
     */
    function imageTo($imagePath, $webpPath): string
    {
        return (new GdImageHelper($imagePath))->convertTo($webpPath, 'webp');
    }
}


