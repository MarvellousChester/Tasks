<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 13:07
 */
include_once 'Orm.php';
class User extends OrmAbstract
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $creationDate;

    private $dbh;

    private $isLoaded = false;
    private $error = false;

    public function __construct($firstName='', $lastName='', $email='')
    {
        $dsn = "mysql:dbname=test_db;host=localhost";
        $user = 'phpmyadmin';
        $password = '123456';
        $this->dbh = new PDO($dsn, $user, $password);

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->creationDate = date('Y-m-d H:i:s');
    }

    protected function setField($field, $value)
    {
        switch($field) {
            case 'first_name': $this->firstName = $value; break;
            case 'last_name': $this->lastName = $value; break;
            case 'email': $this->email = $value; break;
            default: echo 'Please check the field name';

        }
    }
    protected function getField($field)
    {
        switch($field) {
            case 'id': return $this->id;
            case 'first_name': return $this->firstName;
            case 'last_name': return $this->lastName;
            case 'email': return $this->email;
            case 'creation_date': return $this->creationDate;
            default: echo 'Please check the field name';
        }
    }
    protected function loadEntry($id)
    {
        try {
            $statement = $this->dbh->prepare("SELECT * FROM `user` WHERE user_id = ?");
            $statement->execute([$id]);
            $values = $statement->fetch();
            $this->id = $id;
            $this->firstName = $values['first_name'];
            $this->lastName = $values['last_name'];
            $this->email = $values['email'];
            $this->creationDate = $values['creation_date'];
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
            $statement = $this->dbh->prepare("UPDATE `user` SET `first_name` = ?, `last_name` = ?, `email` = ?
                WHERE user_id = ?");
            $inserted = $statement->execute([$this->firstName, $this->lastName, $this->email, $this->id]);
        }
        else
        {
            $statement = $this->dbh->prepare("INSERT INTO `user` (`first_name`, `last_name`, `email`, `creation_date`)
                values (?, ?, ?, ?)");
            $inserted = $statement->execute([$this->firstName, $this->lastName, $this->email, $this->creationDate]);
        }

        echo "$inserted lines added. <br />";
    }
    protected function deleteEntry()
    {
        if($this->isLoaded) {
            $statement = $this->dbh->prepare("DELETE FROM `user` WHERE user_id = ?");
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