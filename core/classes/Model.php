<?php
namespace core\classes;
class Model
{
    use \core\traits\Crud;

    /**
     * @var \RDB
     */
    protected $db = null;

    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $this->db = \RStatic::get('db');
        }
    }
}
