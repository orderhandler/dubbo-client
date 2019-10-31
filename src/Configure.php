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
            'class' => \OrderHandler\Dubbo\Serializer\TcpInvokeSerializer::class,
        ],
        'unserializer' => [
            'class' => \OrderHandler\Dubbo\Unserializer\TcpInvokeUnserializer::class,
        ],
        'connector' => [
            'class' => \OrderHandler\Dubbo\Connector\SwooleTCPClient::class,
            'config' => [
                'open_eof_check' => true,
                'package_eof' => 'dubbo>',
                'package_max_length' => 1024 * 1024 * 8,
                'socket_buffer_size' => 1024 * 1024 * 8,
            ],
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

