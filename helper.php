<?php
/**
 * 数组 转 对象
 * @param array $arr 数组
 * @return object
 */
function arrayToObject($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)arrayToObject($v);
        }
    }

    return (object)$arr;
}

/**
 * 对象 转 数组
 * @param object $obj 对象
 * @return array
 */
function objectToArray($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)objectToArray($v);
        }
    }

    return $obj;
}

/**
 * Returns the type of the var passed.
 *
 * @param mixed $var Variable
 * @return string Type of variable
 * Warning
 *  不要使用 gettype() 来测试某种类型，因为其返回的字符串在未来的版本中可能需要改变。此外，由于包含了字符串的比较，它的运行也是较慢的。
 * 使用 is_* 函数代替。
 */
function KaadonGetType($var)
{
    if (is_array($var)) return "array";
    if (is_bool($var)) return "boolean";
    if (is_float($var)) return "float";
    if (is_int($var)) return "integer";
    if (is_null($var)) return "NULL";
    if (is_numeric($var)) return "numeric";
    if (is_object($var)) return "object";
    if (is_resource($var)) return "resource";
    if (is_string($var)) return "string";
    return "unknown type";
}