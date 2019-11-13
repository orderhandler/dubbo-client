<?php

namespace OrderHandler\Dubbo\Serializer;

class TcpInvokeSerializer{

    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

    /**
     * 请求数据序列化
     *
     * @param $method
     * @param $args
     * @param $provider
     * @param $options
     * @return string
     *
     */
    public function encode($method, $args, $provider, $options){
        $argsString = [];
        foreach($args as $arg){
            $argsString[] = json_encode($arg);
        }

        $cmd = sprintf("invoke %s.%s(%s)", $provider['options']['interface'], $method, implode(',', $argsString));

        return $cmd;
    }

}
