<?php
namespace OrderHandler\Dubbo;

class LoggerInstance{

    private $adapter = null;

    /**
     * LoggerInstance constructor.
     * @param $loggerConfigure
     *
     * @throws \RuntimeException  class must instanceof LoggerInterface
     * @throws \InvalidArgumentException
     *
     */

    public function __construct($loggerConfigure){
        if(is_object($loggerConfigure['class'])){
            if($loggerConfigure['class'] instanceof LoggerInterface){
                $this->adapter = $loggerConfigure['class'];
            }else{
                throw new \RuntimeException("logger" . get_class($loggerConfigure) . " is not instanceof LoggerInterface");
            }
        }elseif(is_string($loggerConfigure['class'])){
            $this->adapter =new $loggerConfigure['class'];
        }else{
            throw new \InvalidArgumentException('logger configure error');
        }
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
