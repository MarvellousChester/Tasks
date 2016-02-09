<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 08.02.16
 * Time: 14:03
 */
interface PsrInterface
{
    public function error($message);
    public function warning($message);
    public function notice($message);
}
class LogConstant
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
}

abstract class Logger implements PsrInterface
{
    public function error($message)
    {
        $this->writeLog($message, LogConstant::ERROR);
    }
    public function warning($message)
    {
        $this->writeLog($message, LogConstant::WARNING);
    }
    public function notice($message)
    {
        $this->writeLog($message, LogConstant::NOTICE);
    }
    abstract protected function writeLog($message, $messageType);
}
class FileLogger extends Logger
{
    private $filename;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    protected function writeLog($message, $messageType)
    {
        $file = fopen($this->filename, 'a+');
        $test = fwrite($file, date('Y-m-d H:i:s') . ' ' . ' error: ' . $message . "\n");
        if ($test) echo 'Данные в файл успешно занесены. <br />';
        else echo 'Ошибка при записи в файл. <br />';
        fclose($file);
    }
}
class DatabaseLogger extends Logger
{
    private $user;
    private $password;
    private $dbh;
    public function __construct($host, $user, $password, $db)
    {
        $dsn = "mysql:dbname=$db;host=$host";
        $this->user = $user;
        $this->password = $password;
        $this->dbh = new PDO($dsn, $user, $password);
    }

    protected function writeLog($message, $messageType)
    {
        $statement = $this->dbh->prepare("INSERT INTO `log` (`message`, `type`, `creation_date`) values (?, ?, ?)");
        $inserted = $statement->execute([$message, $messageType, date('Y-m-d H:i:s')]);
        echo "$inserted lines added. <br />";
    }
}

$logger = new DatabaseLogger('localhost','phpmyadmin','123456','test_db');
$logger->error('123');
$logger->notice('Hello');
$logger->warning('LOL WUT?');

$fileLogger = new FileLogger('log.txt');
$fileLogger->error('111');
$fileLogger->warning('LOL WUT?');
$fileLogger->notice('Хз, что я тут пытаюсь кодить...');