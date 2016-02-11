<?php

class PdoConnection
{
    const CONFIG_CONNECTION_FILE = 'Connection.ini';
    private $connectionData;

    /**
     * PdoConnection constructor.
     *
     * @param        $option
     * @param        $connectionData
     *
     */
    public function __construct($option, $connectionData = null)
    {
        switch ($option)
        {
            case 'file': $this->connectionData =
                parse_ini_file(self::CONFIG_CONNECTION_FILE); break;

            case 'directInput': $this->connectionData = $connectionData;
                break;

            default: echo 'Invalid connect configuration option'; break;
        }
    }
    public function establish()
    {
        var_dump($this->connectionData);
        $dbName = $this->connectionData['dbname'];
        $host = $this->connectionData['host'];
        $dsn = "mysql:dbname=$dbName;host=$host";

        $user = $this->connectionData['user'];
        $password = $this->connectionData['password'];
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $dbh = new PDO($dsn, $user, $password, $opt);
        return $dbh;
    }
}