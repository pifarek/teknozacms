<?php

namespace App\Helpers;

class Module{
    public static function display($module_name, $params = []){
        $class_name = '\App\Modules\\' . ucfirst($module_name);
        $module = new $class_name($params);
        return $module->display();
    }
}