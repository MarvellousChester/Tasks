<?php
include_once 'Entity.php';

class User extends EntityAbstract
{
    /**
     * User constructor.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function __construct($dbh, $data)
    {
        $this->dbh = $dbh;

        $this->data = $data;
        $this->data['creation_date'] = date('Y-m-d H:i:s');
        parent::__construct();
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