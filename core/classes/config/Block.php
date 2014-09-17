<?php
namespace core\classes\config;

class Block extends \core\classes\Config
{
    public $controller = false;
    public $method = false;
    public $view = false;

    public $place = 'center';
    public $sort = 0;

    public function run($method_params = array())
    {
        $view_params = array();
        if ($this->controller && $this->method) {

            $class_name = '\\' . APP_NAME . '\\controllers\\' . $this->controller;

            $controller = new $class_name($this->method, array_merge($this->params, $method_params));

            $view_params = $controller->run();
        }

        $content = '';

        if ($this->view) {

            $view = new \core\classes\View(APP_VIEW_DIR . DS . $this->view . '.php', $view_params);

            ob_start();

            $view->render();

            $content = ob_get_clean();
        }

        return $content;
    }
}
