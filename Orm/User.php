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
    public function __construct($firstName='', $lastName='', $email='')
    {
        $this->data['first_name'] = $firstName;
        $this->data['last_name'] = $lastName;
        $this->data['email'] = $email;
        $this->data['creation_date'] = date('Y-m-d H:i:s');
        parent::__construct();
    }

    protected function loadEntry($id)
    {
        $statement = $this->dbh->prepare(
            "SELECT * FROM `user` WHERE user_id = ?"
        );
        $statement->execute([$id]);
        $values = $statement->fetch();
        if($values == false)
        {
            echo "No entry was found <br />";
            return false;
        }
        $this->data = $values;
    }
    protected function saveEntry()
    {
        if($this->isLoaded)
        {
            $statement = $this->dbh->prepare(
                "UPDATE `user`
                SET `first_name` = ?, `last_name` = ?, `email` = ?
                WHERE user_id = ?");
            $inserted = $statement->execute(
                [$this->data['first_name'],
                 $this->data['last_name'],
                 $this->data['email'],
                 $this->data['user_id']]);
        }
        else
        {
            $statement = $this->dbh->prepare(
                "INSERT INTO `user`
               (`first_name`, `last_name`, `email`, `creation_date`)
                values (?, ?, ?, ?)");
            $inserted = $statement->execute(
                [$this->data['first_name'],
                 $this->data['last_name'],
                 $this->data['email'],
                 $this->data['creation_date']]);
        }

        echo "$inserted lines added. <br />";
    }
    protected function deleteEntry()
    {
        if($this->isLoaded) {
            $statement = $this->dbh->prepare("DELETE FROM `user`
                WHERE user_id = ?");
            $inserted = $statement->execute([$this->data['user_id']]);
            echo "$inserted entry was deleted <br />";
            $this->isLoaded = false;
        }
        else echo 'You must load an entry before deleting <br />';
    }

    public function getId()
    {
        if(array_key_exists('user_id', $this->data)) return $this->data['user_id'];
        else return false;
    }

}