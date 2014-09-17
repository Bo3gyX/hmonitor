<?php
namespace core\classes\config;

class Page extends \core\classes\Config
{
    public $public = true;
    public $blocks = array();

    public $go = null;
    public $redirect = null;
    public $layout = null;

    public $request_params = array();

    protected $url_pattern = null;

    public function setUrlPattern($url_pattern)
    {
        $this->url_pattern = $url_pattern;

        return $this;
    }

    public function getUrlPattern()
    {
        return $this->url_pattern;
    }

    public function getPlaceContent()
    {
        $views_params = array();

        $blocks = array_merge($this->layout->blocks, $this->blocks);
        foreach ($blocks as $block) {

            $content = $block->run($this->request_params);

            if (!isset($views_params[$block->place])) {
                $views_params[$block->place] = '';
            }

            $block_name = implode('->', array($block->controller, $block->method, $block->view));

            $views_params[$block->place] .=
                PHP_EOL . '<!--// start ' . $block_name . ' //-->' . PHP_EOL .
                $content .
                PHP_EOL . '<!--// end ' . $block_name . ' //-->' . PHP_EOL;
        }

        return $views_params;
    }
}
