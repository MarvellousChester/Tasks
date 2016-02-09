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
    protected $isLoaded = false;
    protected $error = false;
    protected $dbh;

    protected function __construct()
    {
        $dsn = "mysql:dbname=test_db;host=localhost";
        $user = 'phpmyadmin';
        $password = '123456';
        $this->dbh = new PDO($dsn, $user, $password);
    }

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
        try {
            $operation = $this->loadEntry($id);
        }
        catch (Exception $ex)
        {
            $this->error = true;
            echo $ex;
        }
        finally
        {
            if($this->error == null) $this->isLoaded = true;
            return $operation;
        }
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