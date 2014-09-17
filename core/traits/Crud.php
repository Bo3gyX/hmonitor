<?php
namespace core\traits;

trait Crud
{
    public function rFindByParams($params)
    {
        $sql = 'SELECT * FROM `' . static::TAB_NAME . '`';

        $where = array();
        foreach ($params as $key => $val) {
            $where[] = '`' . $key . '` = "' . $val . '"';
        }

        if (count($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $res = $this->db->query($sql);

        return $res;
    }

    public function iFindByParams($params)
    {
        $res = $this->rFindByParams($params);

        $i = new \RDB_Iterator($res->result);

        return $i;
    }

    public function aFindByParams($params)
    {
        $iRes = $this->iFindByParams($params);

        $rows = $iRes->toArray();

        return $rows;
    }

    public function insert($params)
    {
        $field_name = array();
        $field_value = array();

        foreach ($params as $key => $val) {
            $field_name[] = '`' . $key . '`';
            $field_value[] = '"' . $val . '"';
        }

        $sql = 'INSERT `' . static::TAB_NAME . '` (' . implode(',', $field_name) . ') VALUES (' . implode(',', $field_value) . ')';

        $res = $this->db->query($sql);

        return $res;
    }

    public function update($id, $params)
    {
        $set = array();
        foreach ($params as $key => $val) {
            $set[] = '`' . $key . '` = "' . $val . '"';
        }

        $sql = 'UPDATE `' . static::TAB_NAME . '` SET ' . implode(',', $set) . ' WHERE `id` = ' . $id;

        $res = $this->db->query($sql);

        return $res;
    }
}


