<?php
namespace CGI\Trainee;

use CGI\Orm\EntityAbstract;


class User extends EntityAbstract
{
    protected function saveEntry()
    {
        if($this->isLoaded) {
            $statement = self::$dbh->prepare(
                "UPDATE `user`
                SET `first_name` = ?, `last_name` = ?, `email` = ?
                WHERE user_id = ?"
            );
            $inserted = $statement->execute(
                [$this->data['first_name'],
                 $this->data['last_name'],
                 $this->data['email'],
                 $this->data['user_id']]
            );
        }
        else {
            $statement = self::$dbh->prepare(
                "INSERT INTO `user`
               (`first_name`, `last_name`, `email`, `creation_date`)
                VALUES (?, ?, ?, ?)"
            );
            $inserted = $statement->execute(
                [$this->data['first_name'],
                 $this->data['last_name'],
                 $this->data['email'],
                 date('Y-m-d H:i:s')]
            );
        }

        echo "$inserted lines added. <br />";
    }

    public function getId()
    {
        if(array_key_exists('user_id', $this->data))
            return $this->data['user_id'];
        else return false;
    }
    protected function getTableName()
    {
        return 'user';
    }

}