<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 15:15
 */
include_once 'Entity.php';

class Category extends EntityAbstract
{

    /**
     * Category constructor.
     *
     * @param string $name
     * @param string $urlKey
     */
    public function __construct($dbh, $data)
    {
        $this->dbh = $dbh;
        $this->data = $data;
        parent::__construct();
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

    public function getId()
    {
        if(array_key_exists('category_id', $this->data))
            return $this->data['category_id'];
        else return false;
    }
    protected function getTableName()
    {
        return 'category';
    }
}