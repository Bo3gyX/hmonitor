<?php
namespace hmonitor\classes\forms;

class HostAdd extends \core\classes\Form
{
    public function __construct()
    {
        $this->salt = 'UCeUfpqbB4LT79TK';

        parent::__construct('host_add');
    }
} 