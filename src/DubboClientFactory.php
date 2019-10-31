<?php

namespace OrderHandler\Dubbo;

use OrderHandler\Dubbo\DiscoverService\ServiceProvider;

use OrderHandler\Dubbo\DubboClient;
use OrderHandler\Dubbo\Configure;
use OrderHandler\Dubbo\LoggerInstance;


class DubboClientFactory
{

    public $configure =null;

    private $discover = null;

    private $serializer = null;

    private $unserializer = null;

    private $connector = null;

    private $service = [];

    private $logger = null;

    public function __construct($conf) {
        $this->configure = new Configure($conf);
        $this->logger = new LoggerInstance($this->configure->getLoggerConf());
        $this->initDiscover($this->configure->getDiscoverConf());
        $this->initSerialier($this->configure->getSerializerConf());
        $this->initUnserialier($this->configure->getUnserializerConf());
    }

    private function initSerialier($conf){
        $className = $conf['class'];
        $this->serializer =  new $className($conf);
    }
    private function initUnserialier($conf){
        $className = $conf['class'];
        $this->unserializer =  new $className($conf);
    }

    private function initDiscover($conf){
        $class = $conf['type'];
        $this->discover = new $class($conf);
    }

    public static function make($service, $conf = []){
        $factory = new DubboClientFactory($conf);
        return $factory->makeService($service);
    }

    public function makeService($service) {

        $provider = $this->discover->loadProvider($service) ;

        $this->logger->debug("search service [{$service}] return : " . json_encode($provider));


        $client = new DubboClient($provider, $this->configure->getClientOptions());
        $client->setLogger($this->logger);
        $client->setSerializer($this->serializer);
        $client->setUnserializer($this->unserializer);
        $client->setConnector($this->loadConnector($provider, $this->configure->getClientOptions(), $this->configure->getConnectorConfig()));

        return $client;

       //$service, $registry, $version
//      $client = new DubboClient($conf);
//      $client->setLggger($this->logger);
//      return $client;
    }

    public function loadConnector($provider, $options, $config){
        $className = $config['class'];
        $connector = new $className($provider, $options, $config);
        $this->connector = $connector;
        return $this->connector;
    }

}
