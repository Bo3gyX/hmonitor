<?php
mb_internal_encoding("UTF-8");

define('DS', DIRECTORY_SEPARATOR);

define('APP_NAME', basename(APP_DIR));
define('BASE_DIR', dirname(__DIR__));
define('CORE_DIR', BASE_DIR . DS. 'core');
define('LIB_DIR', BASE_DIR . DS. 'lib');

define('APP_CONFIG_DIR', APP_DIR . DS. 'config');
define('APP_VIEW_DIR', APP_DIR . DS. 'views');
define('APP_LAYOUT_DIR', APP_DIR . DS. 'layouts');

function __autoload($class_name)
{
    $file_name = BASE_DIR . DS . $class_name;
    $file_name = str_replace('\\', DS, $file_name).'.php';

    if (file_exists($file_name)) {
        require_once $file_name;
    }
}

require_once LIB_DIR . DS . 'RLib/rdb.php';
require_once LIB_DIR . DS . 'RLib/rstatic.php';
require_once LIB_DIR . DS . 'RLib/rdbiterator.php';

require_once APP_DIR . DS . 'config.php';

RStatic::set('config',  $config = new \core\classes\config\Config($config));
RStatic::set('db',      $db = new RDB('localhost', 'hmadmin', 'hmadmin', strtolower(APP_NAME)));
RStatic::set('request', $request = new \core\classes\Request());

if ($request->str_path) {
    $page = $config->findPageByRequest($request);
} else {
    $page = $config->getPageByTemplate('index');
}

if (!$page) {
    $page = $config->getPageByTemplate('404');
}

if (!$page) {
    header("HTTP/1.0 404 Not Found");
    exit('Error 404');
}

$page = $config->findRealPage($page);

if ($page->redirect) {
    header("HTTP/1.0 301 Moved Permanently");
    header("Location:" . $page->redirect);
    exit;
}

RStatic::set('session', $session = \core\classes\Session::instance()->start());
RStatic::set('page',    $page);
RStatic::set('layout',  $layout = $page->layout);
RStatic::set('params',  $all_params = array_merge($config->params, $layout->params, $page->params));

$layout_params = array_merge($all_params, $page->getPlaceContent());
$layout = new \core\classes\View(APP_LAYOUT_DIR . DS . $layout->name . '.php', $layout_params);
$layout->render();