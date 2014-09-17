<?php
namespace core\classes;

class Auth
{
    use \core\traits\Instance;

    const AUTH_KEY = 'auth';

    public function setUser($aUser)
    {
        $this->getSession()->set(static::AUTH_KEY, $aUser);

        return $this;
    }

    public function getUser()
    {
        return $this->getSession()->get(static::AUTH_KEY);
    }

    public function has()
    {
        return $this->getSession()->has(static::AUTH_KEY);
    }

    public function reset()
    {
        return $this->getSession()->del(static::AUTH_KEY);
    }

    protected function getSession()
    {
        return \core\classes\Session::instance();
    }

}