<?php

namespace OrderHandler\Dubbo;


class DubboClient{

    private $serializer = null;

    private $unserializer = null;

    private $provider = [];

    private $options = [];

    public function __construct($provider, $options){
        $this->provider = $provider;
        $this->options = $options;

    }

    public function setSerializer($serializer){
        $this->serializer = $serializer;
    }

    public function setUnserializer($unserializer){
        $this->unserializer = $unserializer;
    }


    public function __call($method, $args){

    }


}

