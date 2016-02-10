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

    /**
     * Category constructor.
     *
     * @param string $name
     * @param string $urlKey
     */
    public function __construct($name='', $urlKey='')
    {
        $this->data['name'] = $name;
        $this->data['url_key'] = $urlKey;
        parent::__construct();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    protected function loadEntry($id)
    {
            $statement = $this->dbh->prepare("SELECT * FROM `category`
                WHERE category_id = ?");
            $statement->execute([$id]);
            $values = $statement->fetch();
            $this->data = $values;
        return $this->data;
    }

    protected function saveEntry()
    {
        //Если url_key отсутствует, то формируем его на основе name
        if($this->data['url_key'] == '')
            $this->data['url_key'] = $this->data['name'];
        //Приводим url_key в нужный формат
        $this->data['url_key'] =
            mb_strtolower(strtr(trim($this->data['url_key']), ' ', '-'));
        if($this->isLoaded)
        {
            $statement = $this->dbh->prepare(
                "UPDATE `category`
                 SET `name` = ?, `url_key` = ?
                 WHERE category_id = ?");
            $inserted = $statement->execute(
                [$this->data['name'],
                 $this->data['url_key'],
                 $this->data['category_id']]);
        }
        else
        {
            $statement = $this->dbh->prepare(
                "INSERT INTO `category` (`name`, `url_key`) values (?, ?)");
            $inserted = $statement->execute(
                [$this->data['name'],
                 $this->data['url_key']]);
        }

        echo "$inserted lines added. <br />";
    }

    protected function deleteEntry()
    {
        if($this->isLoaded) {
            $statement = $this->dbh->prepare("DELETE FROM `category`
                WHERE category_id = ?");
            $inserted = $statement->execute([$this->data['category_id']]);
            echo $inserted . 'entry was deleted';
        }
        else echo 'You must load an entry before deleting';
    }

    public function getId()
    {
        if(array_key_exists('category_id', $this->data)) return $this->data['category_id'];
        else return false;
    }
}