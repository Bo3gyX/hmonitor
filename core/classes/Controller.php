<?php
namespace core\classes;

class Controller
{
    protected $params = array();

    protected $method = null;
    protected $method_params = array();

    public function __construct($method = null, $method_params = array())
    {
        if ($method) {
            $this->setAction($method, $method_params);
        }

        $this->init();
    }

    public function setAction($method, $method_params = array())
    {
        $this->method = $method;
        $this->method_params = $method_params;

        return $this;
    }

    public function run()
    {
        if (is_null($this->method)) {
            throw new \Exception ('Method not set');
        }

        return call_user_func_array(array($this, $this->method), $this->method_params);
    }

    protected function init()
    {

    }

    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}