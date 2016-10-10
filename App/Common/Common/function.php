<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/7 0007
 * Time: 23:56
 */
function catTree(&$list,$data, $pid = 0, $level = 0)
{
    if (!is_null($pid)) {
        foreach ($data as $tmp) {
            if ($tmp['pid'] == $pid) {
                $list[$tmp['id']]['main']  = $tmp;
                $list[$tmp['id']]['level'] = $level;
                catTree($list[$tmp['id']]['child'], $data,$tmp['id'], $level + 1);
            }
        }
    }
}

/**
 * 方便打印输出查看数据
 * 使用方式：pp($val1,$arr,$val2)等等可以连续打印多个
 */
function pp()
{
    $arr = func_get_args();
    echo '<pre>';
    foreach($arr as $val) {
        print_r($val);
        echo '</pre>';
        echo '<pre>';
    }
    echo '</pre>';
}

function ppd()
{
    $arr = func_get_args();
    echo '<pre>';
    foreach($arr as $val) {
        print_r($val);
        echo '</pre>';
        echo '<pre>';
    }
    echo '</pre>';
    die();
}