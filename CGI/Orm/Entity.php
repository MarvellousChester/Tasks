<?php
namespace CGI\Orm;

include 'OrmInterface.php';
require_once '../CGI/Connection/PdoConnection.php';

use PDO;
use CGI\Connection\PdoConnection;
use CGI\Logger\DatabaseLogger;
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 12:37
 */

abstract class EntityAbstract implements OrmInterface
{
    protected $data = [];
    protected $isLoaded = false;
    protected $error = false;
    protected static $dbh = null;

    protected $table;
    protected $primaryKey;

    public function __construct($data = [])
    {
        if (self::$dbh == null) {
            $connection = new PdoConnection('file');
            self::$dbh = $connection->establish();
        }

        $this->data = $data;
        $this->table = $this->getTableName();

        $statement = self::$dbh->query(
            'SHOW COLUMNS FROM ' . $this->getTableName()
        );
        $this->primaryKey = $statement->fetch(PDO::FETCH_NUM)[0];

    }

    public function set($field, $value)
    {
        $this->data[$field] = $value;
    }

    public function get($field)
    {
        if (array_key_exists($field, $this->data)) {
            return $this->data[$field];
        } else {
            return false;
        }
    }

    public function load($id)
    {
        $sqlQuery = "SELECT * FROM `" . $this->table
            . "` WHERE $this->primaryKey = ?";

        $statement = self::$dbh->prepare($sqlQuery);
        $statement->execute([$id]);
        $values = $statement->fetch();
        if ($values == false) {
            echo "No entry was found <br />";
            return false;
        }
        $this->data = $values;
        $this->isLoaded = true;
        return $this->data;
    }

    public function save()
    {
        try {
            $this->saveEntry();
        } catch (Exception $ex) {
            echo "An error has occurred while saving the data: $ex <br />";
        }
    }

    public function delete()
    {
        if ($this->isLoaded) {
            $sqlQuery = "DELETE FROM `" . $this->table
                . "` WHERE $this->primaryKey = ?";

            $statement = self::$dbh->prepare($sqlQuery);
            var_dump($this->data[$this->primaryKey]);
            $inserted = $statement->execute([$this->data[$this->primaryKey]]);
            echo "$inserted entry was deleted <br />";
            $this->isLoaded = false;
        } else {
            echo 'You must load an entry before deleting <br />';
        }
    }

    protected abstract function saveEntry();

    protected abstract function getTableName();
}