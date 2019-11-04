<?php
namespace OrderHandler\Dubbo\Logger;
use OrderHandler\Dubbo\LoggerInterface;


/***
 * Class EchoLogger
 * @package OrderHandler\Dubbo\Logger
 *
 */
class EchoLogger implements LoggerInterface{

    public function debug($msg){
        echo $msg . "\n\n";
    }

    public function info($msg){
        echo $msg . "\n\n";
    }

    public function warning($msg){
        echo $msg . "\n\n";
    }

    public function error($msg, $exception = null){
        echo $msg . "\n";
        if($exception != null ){
            echo $exception->__toString();
        }
        echo "\n";
    }


}


