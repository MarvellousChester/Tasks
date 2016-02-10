<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 12:37
 */
require 'OrmInterface.php';

abstract class OrmAbstract implements Orm_OrmInterface
{
    protected $data = Array();
    protected $isLoaded = false;
    protected $error = false;
    protected $dbh;

    /**
     * OrmAbstract constructor.
     */
    protected function __construct()
    {
        $dsn = "mysql:dbname=test_db;host=localhost";
        $user = 'phpmyadmin';
        $password = '123456';
        $this->dbh = new PDO($dsn, $user, $password);
    }

    public function set($field, $value)
    {
        $this->data[$field] = $value;
    }

    public function get($field)
    {
        if(array_key_exists($field, $this->data)) return $this->data[$field];
        else return false;
    }

    public function load($id)
    {
        try {
            $operation = $this->loadEntry($id);
            if($operation == false) throw new Exception('Entry not found!');
        }
        catch (Exception $ex)
        {
            $this->error = true;
            echo "An error has occurred while loading the data: $ex <br />";
        }
        finally
        {
            if($this->error != true)
            {
                $this->isLoaded = true;
                return $operation;
            }
            else return null;

        }
    }

    public function save()
    {
        try {
            $this->saveEntry();
        }
        catch (Exception $ex)
        {
            echo "An error has occurred while saving the data: $ex <br />";
        }
    }

    public function delete()
    {
        try {
            $this->deleteEntry();
        }
        catch (Exception $ex)
        {
            echo "An error has occurred while deleting the data: $ex <br />";
        }
    }

    protected abstract function loadEntry($id);
    protected abstract function saveEntry();
    protected abstract function deleteEntry();
}