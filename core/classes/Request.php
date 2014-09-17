<?php
namespace core\classes;

class Request
{
    public $host = null;
    public $uri = null;
    public $str_path = null;
    public $str_params = null;

    public $method = null;
    public $get = array();
    public $post = array();

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->host = str_replace('www.', '', trim($_SERVER['SERVER_NAME'], '/'));

        $request_part = explode('?', trim($_SERVER['REQUEST_URI'], '/'), 2);

        $this->str_path = isset($request_part[0]) ? trim($request_part[0], '/') : null;
        $this->str_params = isset($request_part[1]) ? $request_part[1] : null;

        $uri = $this->str_path;
        $uri .= $this->str_params ? '?' . $this->str_params : '';

        $this->uri = $uri;

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->get = $_GET;
        $this->post = $_POST;
    }
}