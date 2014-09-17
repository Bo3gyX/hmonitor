<?php

class RDB_Iterator implements Iterator {

    private $result = null;
    private $current = null;
    private $iterator = 0;
    private $num_rows = 0;

    private $call_filters = array();
    private $call_mod = array();

    public function __construct($result)
    {
        $this->iterator = 0;
        $this->result = $result;
        $this->num_rows = mysql_num_rows($this->result);
    }

    public function addFilter($call) {

        $this->call_filters[] = $call;

        return $this;
    }

    public function addMod($call) {

        $this->call_mod[] = $call;

        return $this;
    }

    public function toArray()
    {
        $arr = array();

        foreach ($this as $key => $val)
        {
            $arr[$key] = $val;
        }

        return $arr;
    }

    public function rewind()
    {
        $this->iterator = 0;
    }

    public function current()
    {
        foreach ($this->call_mod as $call_mod) {
            $this->current = $this->call($call_mod, array($this->current));
        }

        return $this->current;
    }

    public function key()
    {
        $key = $this->iterator;
        if (isset($this->current['id'])) {
            $key = $this->current['id'];
        }

        return $key;
    }

    public function next()
    {
        $this->iterator++;
    }

    public function valid()
    {
        if ($this->iterator > $this->num_rows - 1) {
            return false;
        };

        $this->current = null;

        mysql_data_seek($this->result, $this->iterator);
        $row = mysql_fetch_assoc($this->result);

        $is_filter = false;
        foreach ($this->call_filters as $call_filters) {

            if (!$this->call($call_filters, array($row))) {
                $is_filter = true;
                break;
            }
        }

        if ($is_filter) {
            $this->next();
            $valid = $this->valid();
        } else {
            $this->current = $row;
            $valid = true;
        }

        return $valid;
    }

    protected function call($call, $param) {

        $res = call_user_func_array($call, $param);

        return $res;
    }

}