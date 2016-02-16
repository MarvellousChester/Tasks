<?php
namespace Cgi\Orm;

use PDO;
use Cgi\Connection\PdoConnection;
//use Cgi\Logger\DatabaseLogger;
use Cgi\Logger\FileLogger;

/**
 * An abstract entity class. All derived classes must represent a specific
 * database entity
 */

abstract class EntityAbstract implements OrmInterface
{
    protected $data = [];
    protected $isLoaded = false;
    protected $error = false;

    protected static $dbh = null;
    protected static $logger = null;

    private $connection = null;

    protected $table;
    protected $primaryKey;
    protected $fields = [];

    /**
     * EntityAbstract constructor.
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        if (self::$logger == null) {
            self::$logger = new FileLogger('log.txt');
        }

        if (self::$dbh == null) {
            try {
                $this->connection = new PdoConnection('file');
                self::$dbh = $this->connection->establish();
            } catch (\PDOException $ex) {
                self::$logger->error($ex);
            }

        }

        $statement = self::$dbh->query(
            'SHOW COLUMNS FROM ' . $this->getTableName()
        );
        if ($statement) {
            $this->primaryKey = $statement->fetch(PDO::FETCH_NUM)[0];
            foreach ($statement as $item) {
                $this->fields[] = $item['Field'];
            }

        } else {
            self::$logger->error(
                "En error has occurred while getting the PRIMARY KEY from
            table $this->getTableName(): $statement->errorInfo()"
            );
        }
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
        $this->table = $this->getTableName();
    }

    /**
     * Set the value of field
     * @param $field
     * @param $value
     */
    public function set($field, $value)
    {
        if (in_array($field, $this->fields)) {
            $this->data[$field] = $value;
        } else {
            self::$logger->notice(
                "En error while inserting value to field $field : such field is not exist"
            );
        }
    }

    /**
     * @param $field
     *
     * @return data
     */
    public function get($field)
    {
        if (array_key_exists($field, $this->data)) {
            return $this->data[$field];
        } else {
            return null;
        }
    }

    public function load($id)
    {
        $sqlQuery = "SELECT * FROM `" . $this->table
            . "` WHERE $this->primaryKey = ?";

        $statement = self::$dbh->prepare($sqlQuery);
        $statement->execute([$id]);
        $values = $statement->fetch();
        if ($values == null) {
            self::$logger->notice("Can't find en entry with ID: $id ");
        } else {
            $this->data = $values;
            $this->isLoaded = true;
        }

        return $this->data;
    }

    public function save()
    {
        $this->beforeSave();

        $queryMas = [];
        $insertMas = [];
        foreach ($this->data as $key => $value) {
            if ($key != $this->primaryKey) {
                $queryMas[$key] = '`' . $key . '` = ?';
                $insertMas[] = $value;
            }
        }

        if ($this->isLoaded) {

            $query = "UPDATE `$this->table` SET " . implode(', ', $queryMas)
                . " WHERE $this->primaryKey = ?";

            $statement = self::$dbh->prepare($query);

            array_push($insertMas, $this->data[$this->primaryKey]);

            $inserted = $statement->execute($insertMas);
        } else {
            foreach ($this->fields as $key => $value) {
                $this->fields[$key] = "`$value`";
                $items[] = '?';
            }
            $query = "INSERT INTO `$this->table` (" . implode(
                    ', ', $this->fields
                ) . ") VALUES (" . implode(', ', $items) . ")";

            $statement = self::$dbh->prepare($query);
            $inserted = $statement->execute($insertMas);
        }

        echo "$inserted lines added. <br />";

    }

    public function delete()
    {
        if ($this->isLoaded) {
            $sqlQuery = "DELETE FROM `" . $this->table
                . "` WHERE $this->primaryKey = ?";

            $statement = self::$dbh->prepare($sqlQuery);
            $inserted = $statement->execute([$this->data[$this->primaryKey]]);
            echo "$inserted entry was deleted <br />";
            $this->isLoaded = false;
            $this->data[$this->primaryKey] = null;
        } else {
            self::$logger->notice("You must load an entry before deleting");
        }
    }

    /**
     * Returns ID of the entry
     * @return mixed
     */
    public function getId()
    {
        return $this->primaryKey;
    }
    /**
     * Returns the name of the table
     * @return mixed
     */
    abstract protected function getTableName();

    /**
     *Called before save() method
     */
    protected function beforeSave()
    {

    }
}