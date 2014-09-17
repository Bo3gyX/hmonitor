<?php

class RDB_Result {

    public $sql;
    public $time;
    public $result;

    public function __construct($result, $time = null, $sql = null){

        $this->result = $result;

        if (!is_null($time)){
            $this->time = $time;
        }

        if (!is_null($sql)){
            $this->sql = $sql;
        }

    }

    public function toAssoc($hasId = true, $idField = 'id'){

        if (mysql_num_rows($this->result) > 0) {
            mysql_data_seek($this->result, 0);
        };

        $res = array();
        while ($row = $this->fetchToAssoc()){

            if ($hasId){
                $res[$row[$idField]] = $row;
            }
            else{
                $res[] = $row;
            }
        }

        return $res;
    }

    public function rowAssoc()
    {
        $res = $this->toAssoc();
        return array_shift($res);
    }

    public function fetchToAssoc(){

        return mysql_fetch_assoc($this->result);

    }

}