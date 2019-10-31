<?php

namespace OrderHandler\Dubbo\Serializer;

class TcpInvokeSerializer{

    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

    public function encode($method, $args, $provider, $options){
        $cmd = sprintf("invoke %s.%s(%s)", $provider['options']['interface'], $method, json_encode($args));

        return $cmd;
    }

}
