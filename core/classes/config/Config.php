<?php
namespace core\classes\config;

class Config extends \core\classes\Config
{
    public $layout = null;
    public $pages = array();

    public $request_params = array();

    public function findPageByRequest(\core\classes\Request $request)
    {
        if (!$request->str_path) {
            return false;
        }

        $find_template = null;
        $request_params = array();

        $templates = array_keys($this->pages);

        foreach ($templates as $template)
        {
            $template_parse = $this->parseTemplate($template);

            $reg = $template_parse['reg'];
            $params = $template_parse['params'];

            if (preg_match($reg, $request->str_path, $m)) {

                array_shift($m);

                $this->request_params = array_combine($params, $m);
                $find_template = $template;

                break;
            }
        }

        return $this->getPageByTemplate($find_template, $this->request_params);
    }

    public function getPageByTemplate($templ, $request_params = array())
    {
        if (isset($this->pages[$templ])) {

            $page = $this->pages[$templ];
            $page->request_params = $request_params;

            return $page;
        }

        return false;
    }

    public function findRealPage($page, $params = array())
    {
        if (!$page instanceof \core\classes\config\Page) {
            $page = $this->getPageByTemplate($page);
        }

        if (!$page) {
            return false;
        }

        $page->params = array_merge($page->params, $params);

        if (!$page->layout) {
            $page->layout = $this->layout;
        }

        if ($page->redirect) {
            return $page;
        }

        if ($page->go) {
            $page = $this->findRealPage($page->go->page, $page->go->params);
        }

        return $page;
    }

    protected function parseTemplate($template)
    {
        $template_parts = explode('/', $template);
        $template_params = array();

        foreach ($template_parts as &$part) {

            if ($part[0] == '#') {
                $template_params[] = str_replace('#', '', $part);
                $part = '([^/]+)';
            }
        }

        $template = '~^' . implode('/', $template_parts) . '$~';

        $result = array(
            'reg' => $template,
            'params' => $template_params
        );

        return $result;
    }
}
