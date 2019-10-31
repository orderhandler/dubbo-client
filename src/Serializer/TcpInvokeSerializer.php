<?php

namespace OrderHandler\Dubbo\Serializer;

class TcpInvokeSerializer{

    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

    public function encode($method, $args, $provider, $options){
        $argsString = [];
        foreach($args as $arg){
            $argsString[] = json_encode($arg);
        }

        $cmd = sprintf("invoke %s.%s(%s)", $provider['options']['interface'], $method, implode(',', $argsString));

        return $cmd;
    }

}
