<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 15:15
 */
include_once 'Orm.php';
class Category extends OrmAbstract
{
    private $id;
    private $name;
    private $urlKey;

    private $dbh;

    private $isLoaded = false;
    private $error = false;

    public function __construct($name='', $urlKey='')
    {
        $dsn = "mysql:dbname=test_db;host=localhost";
        $user = 'phpmyadmin';
        $password = '123456';
        $this->dbh = new PDO($dsn, $user, $password);

        //$this->name = $name;
        //$this->urlKey = $urlKey;
        $this->setField('name', $name);

        if($urlKey=='') $this->setField('url_key', $name); //Если ключ не задан, то формируем его на основе имени
        else $this->setField('url_key', $urlKey);
    }

    protected function setField($field, $value)
    {
        switch($field) {
            case 'name': $this->name = $value; break;
            case 'url_key': $this->urlKey = strtr(trim($value), ' ', '-'); break;
            default: echo 'Please check the field name';
        }
    }
    protected function getField($field)
    {
        switch($field) {
            case 'name': return $this->name;
            case 'url_key': return $this->urlKey;
            default: { echo 'Please check the field name'; return false;}
        }
    }
    protected function loadEntry($id)
    {
        try{
            $statement = $this->dbh->prepare("SELECT * FROM `category` WHERE category_id = ?");
            $statement->execute([$id]);
            $values = $statement->fetch();
            $this->id = $id;
            $this->name = $values['name'];
            $this->urlKey = $values['url_key'];
        }
        catch (Exception $ex)
        {
            $this->error = true;
            echo $ex;
        }
        finally
        {
            if($this->error == null) $this->isLoaded = true;
        }
    }
    protected function saveEntry()
    {
        if($this->isLoaded)
        {
            $statement = $this->dbh->prepare("UPDATE `category` SET `name` = ?, `url_key` = ?
                WHERE category_id = ?");
            $inserted = $statement->execute([$this->name, $this->urlKey, $this->id]);
        }
        else
        {
            $statement = $this->dbh->prepare("INSERT INTO `category` (`name`, `url_key`)
                values (?, ?)");
            $inserted = $statement->execute([$this->name, $this->urlKey]);
        }

        echo "$inserted lines added. <br />";
    }
    protected function deleteEntry()
    {
        if($this->isLoaded) {
            $statement = $this->dbh->prepare("DELETE FROM `category` WHERE category_id = ?");
            $inserted = $statement->execute([$this->id]);
            echo $inserted . 'entry was deleted';
        }
        else echo 'You must load an entry before deleting';
    }
    public function getId()
    {
        return $this->id;
    }
}