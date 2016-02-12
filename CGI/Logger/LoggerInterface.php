<?php
namespace CGI\Logger;

interface PsrInterface
{
    public function error($message);

    public function warning($message);

    public function notice($message);
}