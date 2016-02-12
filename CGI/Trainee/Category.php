<?php
namespace CGI\Trainee;

use CGI\Orm\EntityAbstract;
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 15:15
 */


class Category extends EntityAbstract
{
    protected function saveEntry()
    {
        //Если url_key отсутствует, то формируем его на основе name
        if($this->data['url_key'] == '')
            $this->data['url_key'] = $this->data['name'];
        //Приводим url_key в нужный формат
        $this->data['url_key'] =
            mb_strtolower(strtr(trim($this->data['url_key']), ' ', '-'));

        if($this->isLoaded) {
            $statement = self::$dbh->prepare(
                "UPDATE `category`
                 SET `name` = ?, `url_key` = ?
                 WHERE category_id = ?"
            );
            $inserted = $statement->execute(
                [$this->data['name'],
                 $this->data['url_key'],
                 $this->data['category_id']]
            );
        }
        else {
            $statement = self::$dbh->prepare(
                "INSERT INTO `category` (`name`, `url_key`) VALUES (?, ?)"
            );
            $inserted = $statement->execute(
                [$this->data['name'],
                 $this->data['url_key']]
            );
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