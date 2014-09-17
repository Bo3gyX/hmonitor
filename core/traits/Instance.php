<?php
namespace core\traits;

trait Instance
{
    static private $_instance;

    /**
     * @return $this
     */
    static public function instance()
    {
        if (!self::$_instance) {

            $class = __CLASS__;

            self::$_instance = new $class();
        }

        return self::$_instance;
    }
}


