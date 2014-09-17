<?php
namespace hmonitor\controllers;

use \core\classes;

class Host extends \core\classes\Controller
{
    public function add()
    {
        $valid = new classes\Result();

        $form = new \hmonitor\classes\forms\HostAdd();

        if ($form->isSubmit()) {

            $values = $form->getValues();

            $valid = $this->validationForm($values);

            if ($valid->result) {

                $values['host_name'] = $valid->data['host_name'];
                $valid = $this->save($values);

            }
        }

        return [
            'form' => $form,
            'valid' => $valid,

        ];

    }

    public function show()
    {
        $cHostCollection = new \hmonitor\classes\HostCollection();

        $list = $cHostCollection->getLastTOP(10);

        return [
            'list' => $list
        ];
    }

    public function search()
    {
        $cHostCollection = new \hmonitor\classes\HostCollection();

        $list = $cHostCollection->findByName('rivergnom');

        return [
            'list' => $list
        ];
    }

    protected function save($values)
    {
        $url = 'http://' . strtolower($values['host_name']);

        $result = classes\Result::success('Хост ' . $url . ' добавлен успешно');

        $cHost = new \hmonitor\classes\Host();

        $cHost->url = $url;
        $cHost->status = 1;

        $save_result = $cHost->save();

        if (!$save_result) {
            $result = classes\Result::failure('Ошибка при сохранении в БД');
        }


        return $result;
    }

    protected function validationForm($values)
    {
        $result = classes\Result::failure('Введите адрес хоста');

        if (!isset($values['host_name'])) {
            return $result;
        }

        $host_name = trim($values['host_name']);
        $host_name = preg_replace(['~https?:\/*~'], '', $host_name);
        $host_name = trim($host_name, '/');

        if (!strlen($host_name)) {

            return $result;
        }

        $result = classes\Result::success('Валидация прошла успешно', ['host_name' => $host_name]);

        return $result;
    }
}