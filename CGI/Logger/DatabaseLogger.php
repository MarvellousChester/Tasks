<?php
namespace CGI\Logger;

use CGI\Connection\PdoConnection;
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.02.16
 * Time: 17:10
 */
class DatabaseLogger extends LoggerAbstract
{
    protected static $dbh;

    public function __construct()
    {
        if (self::$dbh == null) {
            $connection = new PdoConnection('file');
            self::$dbh = $connection->establish();
        }
    }

    protected function writeLog($message, $messageType)
    {
        $statement = self::$dbh->prepare(
            "INSERT INTO `log` (`message`, `type`, `creation_date`) VALUES (?, ?, ?)"
        );
        $inserted = $statement->execute(
            [$message, $messageType, date('Y-m-d H:i:s')]
        );
        echo "$inserted lines added. <br />";
    }
}