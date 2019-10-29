<?php

class LoggerInstance{

    private $adapter = null;

    public function __construct($loggerConfigure){
        if(is_object($loggerConfigure['logger'])){
            if($loggerConfigure['logger'] instanceof LoggerInterface){
                $this->adapter = $loggerConfigure['logger'];
            }else{
                throw new \RuntimeException("logger" . get_class($loggerConfigure['logger']) . " is not instanceof LoggerInterface");
            }
        }elseif(is_string($loggerConfigure['logger'])){
            $logger = new $loggerConfigure['logger'];
        }
        throw new \InvalidArgumentException('logger configure error');
    }

    public function debug($msg){
        return $this->adapter->debug($msg);
    }

    public function error($msg, $exception = null){
        return $this->adapter->error($msg, $exception);

//      if(!is_null($exception)){
//          $msg . "\n" . $exception->__tostring();
//      }
    }

    public function info($msg){
        return $this->adapter->info($msg);
    }

}
