<?php
namespace Cgi\Logger;

interface LoggerInterface
{
    public function error($message);

    public function warning($message);

    public function notice($message);
}