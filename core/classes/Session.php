<?php
namespace core\classes;

class Session {

    use \core\traits\Instance;

    public function start()
    {
        session_start();

        return $this;
    }

    public function destroy()
    {
        session_destroy();

        return $this;
    }

    public function getId()
    {
        return session_id();
    }

    public function setId($id)
    {
        return session_id($id);
    }

    public function getName()
    {
        return session_name();
    }

    public function setName($name)
    {
        return session_name($name);
    }

    public function setLifeTime($lifetime)
    {
        $sparams = session_get_cookie_params();
        $sname = $this->getName();
        $sid = $this->getId();

        if ($lifetime > 0) {
            $lifetime += time();
        }

        setcookie($sname, $sid, $lifetime, $sparams['path'], $sparams['domain'], $sparams['secure'], $sparams['httponly']);

        return $this;
    }

    public function regenerateId()
    {
        return session_regenerate_id(true);
    }

    public function set($key, $val)
    {
        $_SESSION[$key] = $val;

        return $this;
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }

    function has($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        }

        return false;
    }

    public function del($key)
    {
        unset($_SESSION[$key]);

        return $this;
    }

    public function clear()
    {
        $_SESSION = [];

        return $this;
    }
}