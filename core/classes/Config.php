<?php
namespace core\classes;

class Config
{
    use \core\traits\Properties;

    public $params = array();

    public function __construct($init_data = array())
    {
        $this->init($init_data);
    }

    protected function init($init_data)
    {
        if (isset($init_data['layout']) && is_array($init_data['layout'])) {
            $init_data['layout'] = new \core\classes\config\Layout($init_data['layout']);
        }

        if (isset($init_data['pages']) && is_array($init_data['pages'])) {

            foreach ($init_data['pages'] as $url_pattern => &$page) {
                $page = new \core\classes\config\Page($page);
                $page->setUrlPattern($url_pattern);
            }
        }

        if (isset($init_data['blocks']) && is_array($init_data['blocks'])) {

            foreach ($init_data['blocks'] as &$block_data) {
                $block_data = new \core\classes\config\Block($block_data);
            }
        }

        if (isset($init_data['go'])) {

            if (!is_array($init_data['go'])) {
                $init_data['go'] = array(
                    'page' => $init_data['go']
                );
            }

            $init_data['go'] = new \core\classes\config\Go($init_data['go']);
        }

        $this->initProperties($init_data);
    }
}
