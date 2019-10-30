<?php
namespace OrderHandler\Dubbo\Logger;
use OrderHandler\Dubbo\LoggerInterface;

class NoOutputLogger implements LoggerInterface{

    public function debug($msg){}

    public function info($msg){}

    public function warning($msg){}

    public function error($msg, $exception = null){}


}


