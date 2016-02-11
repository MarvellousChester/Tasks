<?php
namespace CGI\Logger;
require_once 'LoggerAbstract.php';
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.02.16
 * Time: 17:07
 */
class FileLogger extends LoggerAbstract
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    protected function writeLog($message, $messageType)
    {
        $file = fopen($this->filename, 'a+');
        $test = fwrite(
            $file, date('Y-m-d H:i:s') . ' ' . ' error: ' . $message . "\n"
        );
        if ($test) {
            echo 'Данные в файл успешно занесены. <br />';
        } else {
            echo 'Ошибка при записи в файл. <br />';
        }
        fclose($file);
    }
}