<?php

namespace OrderHandler\Dubbo;


/***
 * Class DubboClient
 * @package OrderHandler\Dubbo
 *
 */
class DubboClient{

    private $serializer = null;

    private $unserializer = null;

    private $connector = null;

    private $logger = null;

    private $provider = [];

    private $options = [];

    public function __construct($provider, $options){
        $this->provider = $provider;
        $this->options = $options;

    }

    public function setLogger($logger){
        $this->logger = $logger;
    }

    public function setSerializer($serializer){
        $this->serializer = $serializer;
    }

    public function setUnserializer($unserializer){
        $this->unserializer = $unserializer;
    }

    public function setConnector($connector){
        $this->connector = $connector;
    }


    /***
     * @param $method
     * @param $args
     * @return mixed
     *
     */
    public function __call($method, $args){
        $provider = $this->provider;
        $options = $this->options;

        $this->logger->debug("call dubbo rpc {$method}, with provider " . json_encode($provider) . ' with params ' . json_encode($args));
        $requestContent = $this->serializer->encode($method, $args, $provider, $options);
        $this->logger->debug("call dubbo provider : " .json_encode($provider). " with requestContent : " . $requestContent);
        $responseContent = $this->connector->send($requestContent);
        $this->logger->debug("call dubbo provider : " .json_encode($provider). " with responseContent : " . $responseContent);
        return $this->unserializer->decode($responseContent);
    }


}

