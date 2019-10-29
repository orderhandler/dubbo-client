<?php

namespace Orderhandler\Dubbo;

use Orderhandler\Dubbo\DiscoverService\ServiceProvider;

class DubboClientFactory
{

    public $configure =null;

    private $discoverMap = [];

    private $serializerMap = [];

    private $unserializerMap = [];

    private $connectorMap = [];

    private $logger = '';

    public function __construct($conf) {
        $this->configure = new Configure($conf);
        $this->logger = new LoggerInstance($this->configure->getLoggerConf());
    }

    private function init(){

    }

    public function getSerializer($type){
        if(!isset($this->serializerMap[$type])){
            $this->serializerMap[$type] = new Se;
        }
        return $this->serializerMap[$type];
    }


    /**
     * Invoke service's method
     * @param $name method's name
     * @param $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        $provider = $this->getProvider($this->service, $name);
        if (empty($provider)) {
            throw new \Exception('dubbo.providerNotFound');
        }
        $ret = $this->invoke($provider, $name, $arguments);
        return json_decode($ret, true);
    }


    public function makeService($service, $conf = array()) {
        if(static::configure == null){
            static::init();
        }
        $registry = null;
        if (isset($conf['registry'])) {
            $registry = $conf['registry'];
        }
        $version = null;
        if (isset($conf['version'])) {
            $version = $conf['version'];
        }
        //$service, $registry, $version
        $client = new DubboClient($conf);
        $client->setLggger($this->logger);
        return $client;
    }

}
