<?php

namespace OrderHandler\Dubbo;

class Configure{

    private $defaultConfig = [
        'registry' => [
            'type' => \OrderHandler\Dubbo\Discover\ZookeeperDiscover::class,
            'url' => '127.0.0.1:2181',
        ],
        'logger' => [
            'class' => \OrderHandler\Dubbo\Logger\NoOutputLogger::class,
            'options' => [],
        ],
        'serializer' => [
            'class' => \OrderHandler\Dubbo\Logger\NoOutputLogger::class,
        ],
        'unserializer' => [
            'class' => \OrderHandler\Dubbo\Logger\NoOutputLogger::class,
        ],
        'options' => [
            'version' => null,
            'group' => null,
            'options' => [
                'charset' => 'utf-8'
            ],
        ],
    ];

    private $config = [];

    public function __construct($config){
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

}

