<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 12:37
 */
require_once 'OrmInterface.php';

abstract class OrmAbstract implements Orm_OrmInterface
{

    public function set($field, $value)
    {
        $this->setField($field, $value);
    }
    public function get($field)
    {
        return $this->getField($field);
    }
    public function load($id)
    {
        return $this->loadEntry($id);
    }
    public function save()
    {
        $this->saveEntry();
    }
    public function delete()
    {
        $this->deleteEntry();
    }
    protected abstract function setField($field, $value);
    protected abstract function getField($field);
    protected abstract function loadEntry($id);
    protected abstract function saveEntry();
    protected abstract function deleteEntry();
}