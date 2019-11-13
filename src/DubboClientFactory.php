<?php

namespace OrderHandler\Dubbo;

use OrderHandler\Dubbo\DiscoverService\ServiceProvider;

use OrderHandler\Dubbo\DubboClient;
use OrderHandler\Dubbo\Configure;
use OrderHandler\Dubbo\LoggerInstance;

/**
 * Class DubboClientFactory
 * @package OrderHandler\Dubbo
 *
 */
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

    /**
     *
     * @param $conf
     *
     */
    private function initSerialier($conf){
        $className = $conf['class'];
        $this->serializer =  new $className($conf);
    }

    /**
     *
     * @param $conf
     *
     */
    private function initUnserialier($conf){
        $className = $conf['class'];
        $this->unserializer =  new $className($conf);
    }

    /**
     * 默认实例化class ZookeeperDiscover
     *
     */
    private function initDiscover($conf){
        $class = $conf['type'];
        $this->discover = new $class($conf);
    }


    /**
     *
     * @param $service
     * @param array $conf
     * @return \OrderHandler\Dubbo\DubboClient
     *
     * @example $invoke = DubboClientFactory::make($service, $conf);
     *
     *
     */
    public static function make($service, $conf = []){
        $factory = new DubboClientFactory($conf);
        return $factory->makeService($service);
    }


    /**
     * @param $service
     * @return \OrderHandler\Dubbo\DubboClient
     *
     * 调用dubbo服务
     */
    public function makeService($service) {

        $provider = $this->discover->loadProvider($service) ;

        $this->logger->debug("search service [{$service}] return : " . json_encode($provider));


        //初始化DubboClient
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

    /**
     * class SwooleTCPClient instantiate
     *
     */
    public function loadConnector($provider, $options, $config){
        $className = $config['class'];
        $connector = new $className($provider, $options, $config);
        $this->connector = $connector;
        return $this->connector;
    }

}
