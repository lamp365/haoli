<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17/7/13
 * Time: 上午12:13
 */

namespace home\controller;

class index extends \home\controller\base
{
    public function index()
    {
        include themePage('index');
    }
}