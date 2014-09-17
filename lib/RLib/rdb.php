<?php

require_once ('RDB/rdb_result.php');
require_once ('RDB/rdb_query.php');

class RDB {

    public $dbl = null;

    protected $server;
    protected $user;
    protected $password;
    protected $base;

    public function __construct($server,$user,$password,$base){

        $this->connect($server,$user,$password);
        $this->select($base);
    }

    public function connect($server,$user,$password){

        if (!$this->dbl = mysql_connect($server,$user,$password)){
            throw new Exception ("Error connect server `".$server."`.\n".mysql_error(),mysql_errno());
        }

        $this->server = $server;
        $this->user = $user;
        $this->password = $password;

        return true;
    }

    public function select($base){

        if (!mysql_select_db($base, $this->dbl)){
            throw new Exception ("Error select data base `".$base."`.\n".mysql_error(),mysql_errno());
        }

        $this->base = $base;

        return true;
    }

    /**
     * @param $sql
     *
     * @return int|RDB_Result
     *
     * @throws Exception
     */
    public function query($sql){

        $ts = microtime(true);

        $result = mysql_query($sql, $this->dbl);

        $te = microtime(true);

        if ($result === false){
            throw new Exception ("Error query <".$sql.">.\n".mysql_error(),mysql_errno());
        }

        if ($result === true){

            if (strpos(strtolower($sql), 'insert') !== false){

                return mysql_insert_id($this->dbl);
            }

            return mysql_affected_rows($this->dbl);
        }

        $tt = $te-$ts;

        $res = new RDB_Result($result, $tt, $sql);

        return $res;
    }
}
