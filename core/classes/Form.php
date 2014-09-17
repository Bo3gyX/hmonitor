<?php
namespace core\classes;

class Form {

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_REQUEST = 'request';

    public $id = '';
    public $name = '';
    public $method = self::METHOD_POST;
    public $action = '';

    public $salt = '2pSUc48TDPr9CVVC';
    public $session_key = 'session_forms';

    public $param_id = '_form_id';
    public $param_name = '_form_name';

    public function __construct($name = null)
    {
        if ($name != null) {
            $this->init($name);
        }
    }

    public function init($name)
    {
        $this->name = $name;
        $this->id = $this->generateId();

        return $this;
    }

    public function isSubmit()
    {
        $data = $this->getRequestData();

        if ($data === null) {
            throw new \Exception ("Method form {$this->name} not set");
        }

        if (!isset($data[$this->param_id]) || !isset($data[$this->param_name])) {

            $this->registration();

            return false;
        }

        $id = $data[$this->param_id];
        $name = $data[$this->param_name];

        if ($name != $this->name) {

            $this->registration();

            return false;
        }

        if (!$this->checkId($id)) {

            $this->registration();

            return false;
        }

        //$this->unregistration();
        $this->registration();

        return true;
    }

    public function registration()
    {
        $session = \core\classes\Session::instance();

        $session_data = $session->get($this->session_key);

        if (empty($session_data)) {
            $session_data = [];
        }

        $session_data[$this->name] = $this->getHash($this->id);

        $session->set($this->session_key, $session_data);

        return $this;
    }

    public function unregistration()
    {
        $session = \core\classes\Session::instance();

        $session_data = $session->get($this->session_key);

        if (!empty($session_data) && isset($session_data[$this->name])) {

            unset($session_data[$this->name]);

            $session->set($this->session_key, $session_data);
        }

        return $this;
    }

    public function checkId($id)
    {
        $session = \core\classes\Session::instance();

        $session_data = $session->get($this->session_key);

        if (empty($session_data)) {
            return false;
        }

        if (!isset($session_data[$this->name])) {
            return false;
        }

        $hash = $this->getHash($id);

        if ($session_data[$this->name] != $hash) {
            return false;
        }

        return true;
    }

    public function getRequestData()
    {
        $data = null;

        if ($this->method == self::METHOD_GET) {
            $data = $_GET;
        } else if ($this->method == self::METHOD_POST) {
            $data = $_POST;
        } else if ($this->method == self::METHOD_REQUEST) {
            $data = $_REQUEST;
        }

        return $data;
    }

    public function getValues()
    {
        $data = $this->getRequestData();

        $erase_keys = [
            $this->param_id,
            $this->param_name
        ];

        $values = [];
        foreach ($data as $key => $val) {

            if (in_array($key, $erase_keys)) {
                continue;
            }

            $values[$key] = $val;
        }

        return $values;
    }

    /**
     * @return string
     */
    protected function generateId()
    {
        $id = md5($this->name . $this->method . $this->salt . microtime());

        return $id;
    }

    protected function getHash($id)
    {
        $session = \core\classes\Session::instance();

        $hash = md5($id . $session->getId() . $this->salt);

        return $hash;
    }


}