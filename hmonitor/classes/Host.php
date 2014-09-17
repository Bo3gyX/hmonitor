<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 08.09.14
 * Time: 19:58
 */

namespace hmonitor\classes;


class Host
{
    use \core\traits\Properties;

    public $id = null;
    public $url = null;
    public $desc = null;
    public $status = null;
    public $date_create = null;
    public $date_modify = null;

    protected $is_new = null;
    protected $is_loaded = false;
    protected $old_values = [];

    /**
     * @var \hmonitor\models\Host
     */
    protected static $model = null;

    public function __construct()
    {
        self::$model = new \hmonitor\models\Host();
        $this->updateOldValue();
    }

    public function init($data)
    {
        $this->initProperties($data);

        if ($this->id) {
            $this->is_new = false;
        }

        $this->is_loaded = false;
        $this->updateOldValue();

        return $this;
    }

    public function load($id)
    {
        $data = static::$model->aFindByParams(['id' => $id]);

        $this->initProperties($data[$id]);

        $this->is_new = false;
        $this->is_loaded = true;
        $this->updateOldValue();

        return $this;
    }

    public function save()
    {
        $result = null;

        if ($this->id) {
            $result = $this->update();
        } else {
            $result = $this->insert();
        }

        $this->is_loaded = false;
        $this->updateOldValue();

        return $result;
    }

    public function getChanges($strict = false)
    {
        $values_cur = $this->getProperties();
        $values_old = $this->old_values;

        $diff = [];
        $has_diff = false;

        foreach ($values_old as $name => $val_old) {

            $val_cur = $values_cur[$name];

            if ($strict) {

                if ($val_cur !== $val_old) {
                    $has_diff = true;
                }

            } else {

                if ((string)$val_cur != (string)$val_old) {
                    $has_diff = true;
                }
            }

            if ($has_diff) {
                $diff[$name] = $val_cur;
                $has_diff = false;
            }
        }

        return $diff;
    }

    public function hasChanges($strict = false)
    {
        $diff = $this->getChanges($strict);

        if (empty($diff)) {
            return false;
        }

        return true;
    }

    protected function insert()
    {
        $date = date('Y-m-d H:i:s');

        $this->date_create = $date;
        $this->date_modify = $date;

        //$params = $this->getProperties();
        $params = $this->getChanges();

        $new_id = static::$model->insert($params);

        if ($new_id < 1) {
            throw new \Exception ('Error insert in DB');
        }

        $this->id = $new_id;

        $this->is_new = true;

        return true;
    }

    public function getDateCreate($format = 'd.m.Y')
    {
        return $this->formatDate($format, $this->date_create);
    }

    protected function formatDate($format = 'd.m.Y', $date)
    {
        $res = date($format, strtotime($date));

        return $res;
    }

    protected function update()
    {
        $date = date('Y-m-d H:i:s');

        $this->date_modify = $date;

        //$params = $this->getProperties();
        $params = $this->getChanges();

        if (!$this->is_new) {
            unset($params['date_create']);
        }

        $rows = static::$model->update($this->id, $params);

        if ($rows < 1) {
            throw new \Exception ('Error update in DB');
        }

        $this->is_new = false;

        return true;
    }

    protected function updateOldValue()
    {
        $values = $this->getProperties();
        $this->old_values = $values;

        return $this;
    }


} 