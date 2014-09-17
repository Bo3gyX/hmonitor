<?php
namespace core\classes;

class Result {

    public $result = null;
    public $message = null;
    public $data = [];

    public static function success($message, $data = [])
    {
        $result = new Result();
        $result->result = true;
        $result->message = $message;
        $result->data = $data;

        return $result;
    }

    public static function failure($message, $data = [])
    {
        $result = new Result();
        $result->result = false;
        $result->message = $message;
        $result->data = $data;

        return $result;
    }
} 