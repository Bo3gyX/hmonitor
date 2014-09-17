<?php

class RDB_Query {

    protected $fields = array();
    protected $table = array();
    protected $where = array();
    protected $whereOr = array();
    protected $group = array();
    protected $orders = array();

    protected $limit = null;
    protected $offset = 0;

    protected $sql_string = null;

    public function select($arFields) {

        if (!is_array($arFields)) {
            $arFields = array($arFields);
        }

        $this->fields = array_merge($this->fields, $arFields);

        return $this;
    }

    public function from($asTable) {

        if (!is_array($asTable)) {
            $asTable = array($asTable);
        }

        $this->table = array_merge($this->table, $asTable);

        return $this;
    }

    public function where($asWhere) {

        if (!is_array($asWhere)) {
            $asWhere = array($asWhere);
        }

        $this->where = array_merge($this->where, $asWhere);

        return $this;
    }

    public function whereOr($asWhere) {

        if (!is_array($asWhere)) {
            $asWhere = array($asWhere);
        }

        $this->whereOr = array_merge($this->whereOr, $asWhere);

        return $this;
    }

    public function group($arFields) {

        if (!is_array($arFields)) {
            $arFields = array($arFields);
        }

        $this->group = array_merge($this->group, $arFields);

        return $this;
    }

    public function order($arFields) {

        if (!is_array($arFields)) {
            $arFields = array($arFields);
        }

        $this->orders = array_merge($this->orders, $arFields);

        return $this;
    }

    public function limit($int) {

        $this->limit = (int) $int;

        return $this;
    }

    public function offset($int) {

        $this->offset = $int;

        return $this;
    }

    public function build() {

        if (count($this->table) == 0) {
            throw new Exception ('Not specified table');
        }

        $table = implode(',', $this->table);

        $fields = '*';
        if (count($this->fields) > 0) {
            $fields = implode(',', $this->fields);
        }

        $where = null;
        if (count($this->where) > 0) {
            $where = implode(' AND ', $this->where);
        }

        $whereOr = null;
        if (count($this->whereOr) > 0) {
            $whereOr = implode(' OR ', $this->whereOr);
        }

        $group = null;
        if (count($this->group) > 0) {
            $group = implode(',', $this->group);
        }

        $order = null;
        if (count($this->orders) > 0) {
            $order = implode(',', $this->orders);
        }

        $query = sprintf('SELECT %s FROM %s', $fields, $table);

        if (!is_null($where)) {
            $query .= sprintf(' WHERE %s', $where);
        }

        if (!is_null($whereOr)) {
            $query .= sprintf(' OR %s', $whereOr);
        }

        if (!is_null($group)) {
            $query .= sprintf(' GROUP BY %s', $group);
        }

        if (!is_null($order)) {
            $query .= sprintf(' ORDER BY %s', $order);
        }

        if (!is_null($this->limit)) {
            $query .= sprintf(' LIMIT %u,%u', $this->offset, $this->limit);
        }

        $this->sql_string = $query;

        return $this->sql_string;
    }

}