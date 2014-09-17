<?php
namespace core\classes;
class View
{
    protected $filename = null;
    protected $params = array();

    public function __construct($filename = null, $params = array())
    {
        if ($filename) {
            $this->setFile($filename);
            $this->setParams($params);
        }
    }

    public function __set($name, $val)
    {
        $this->params[$name] = $val;
    }

    public function __get($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }

        return null;
    }

    public function setFile($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function render()
    {
        require $this->filename;
    }

    public static function includes($file, $params = array())
    {
        $class = (__CLASS__);

        $view = new $class(APP_VIEW_DIR . DS . $file . '.php', $params);
        return $view->render();
    }
}