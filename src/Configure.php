<?php

namespace OrderHandler\Dubbo;

/**
 * Class Configure
 * @package OrderHandler\Dubbo
 *
 * 初始化dubbo配置
 */
class Configure{

    private $defaultConfig = null;

    private $config = [];

    public function __construct($config){

        $this->defaultConfig = require_once './Config/DefaultConfig.php';
        $this->config = array_merge( $this->defaultConfig, $config);
    }


    public function getLoggerConf(){
        return $this->config['logger'];
    }

    public function getDiscoverConf(){
        return $this->config['registry'];
    }

    public function getClientOptions(){
        return $this->config['options'];
    }

    public function getSerializerConf(){
        return $this->config['serializer'];
    }

    public function getUnserializerConf(){
        return $this->config['unserializer'];
    }

    public function getConnectorConfig(){
        return $this->config['connector'];
    }
}

