<?php

class RStatic{

    public static $data = array();

    public static function set($key,$val){

        self::$data[$key] = $val;

        return true;
    }

    public static function get($key){

        if (self::has($key)) return self::$data[$key];

        //throw new Exception ('Key `'.$key.'` of static not found');
        return false;
    }

    public static function has($key){

        if (isset(self::$data[$key])) return true;

        return false;
    }

    public static function getData()
    {
        return self::$data;
    }
}