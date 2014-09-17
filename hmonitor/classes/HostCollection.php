<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 08.09.14
 * Time: 21:59
 */

namespace hmonitor\classes;

class HostCollection
{
    public function getLastTOP($count)
    {
        $mHost = new \hmonitor\models\Host();

        $list = $mHost->getLastTOP($count);

        return $this->initList($list);
    }

    public function findByName($host_name)
    {
        $host_name = $this->preparationHostName($host_name);

        $mHost = new \hmonitor\models\Host();

        $list = $mHost->findByName($host_name);

        return $this->initList($list);
    }

    protected function initList($data)
    {
        foreach ($data as &$host)
        {
            $cHost = new \hmonitor\classes\Host();
            $cHost->init($host);

            $host = $cHost;
        }

        return $data;
    }

    public function preparationHostName($host_name)
    {
        $host_name = trim($host_name);
        $host_name = preg_replace(['~https?:\/*~'], '', $host_name);
        $host_name = trim($host_name, '/');

        return $host_name;
    }
} 