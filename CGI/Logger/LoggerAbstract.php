<?php
namespace CGI\Logger;
require_once 'LoggerInterface.php';
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 08.02.16
 * Time: 14:03
 */

class LogConstant
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
}

abstract class LoggerAbstract implements PsrInterface
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
