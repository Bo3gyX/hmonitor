<?php
namespace hmonitor\models;

class Host extends \core\classes\Model
{
    const TAB_NAME = 'host';

    public function getLastTOP($count)
    {
        $count = (int) $count;

        $sql = 'SELECT * FROM `' . static::TAB_NAME . '`
                WHERE status = 1
                ORDER BY date_create DESC
                LIMIT 0, ' . $count;

        $res = $this->db->query($sql)->toAssoc();

        return $res;
    }

    public function findByName($host_name, $limit = 50)
    {
        $host_name = strtolower($host_name);
        $limit = (int) $limit;

        $sql = 'SELECT * FROM `' . static::TAB_NAME . '`
                WHERE status = 1
                AND url LIKE("%' . $host_name . '%")
                ORDER BY date_create DESC
                LIMIT 0, ' . $limit;

        $res = $this->db->query($sql)->toAssoc();

        return $res;
    }
}
