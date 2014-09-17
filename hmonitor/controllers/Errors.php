<?php
namespace hmonitor\controllers;

class Errors extends \core\classes\Controller
{
    public function show($cod)
    {
        $result = [
            'cod' => $cod,
            'text' => 'Page Error'
        ];

        if ((int) $cod == 404) {
            header("HTTP/1.0 404 Not Found");
            $result['text'] = 'Page Not Found';
        }

        return $result;
    }

}