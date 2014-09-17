<?php

class RURL_GET_Params
{
    protected $name;
    protected $params = array();
    protected $disable = array();

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function addParams($params_name, $val = null)
    {
        $this->params[$params_name] = $val;

        return $this;
    }

    public function setDisable($arr_names)
    {
        $this->disable = $arr_names;

        return $this;
    }

    public function addDisable($name)
    {
        $this->disable[$name] = 1;
    }

    public function getParams()
    {
        return $this->params;
    }


}

class RURL_GET
{
    protected $get = array();
    protected $params = array();

    public function reg($name, $params, $disable = array())
    {
        $param_obj = new RURL_GET_Params();
        $param_obj->setName($name);
        $param_obj->setParams($params);
        $param_obj->setDisable($disable);

        $this->params[$name] = $param_obj;
    }
}