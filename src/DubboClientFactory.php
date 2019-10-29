<?php

namespace Orderhandler\Dubbo;

use Orderhandler\Dubbo\DiscoverService\ServiceProvider;

class DubboClientFactory
{

    private $adapters = [];

    public function __construct($conf) {

        $this->adapters = $this->initAdapters($conf);

    }


    public function initAdapters($conf){


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


    public static function getService($service, $conf = array()) {
        $registry = null;
        if (isset($conf['registry'])) {
            $registry = $conf['registry'];
        }
        $version = null;
        if (isset($conf['version'])) {
            $version = $conf['version'];
        }
        //$service, $registry, $version
        return new self($conf);
    }








//    /**
//     * The cache of studly-cased words.
//     *
//     * @var array
//     */
//    protected static $studlyCache = [];
//
//    /**
//     * @param string $name
//     * @param array  $config
//     *
//     * @return \dubbo-client\Kernel\ServiceConnection
//     */
//    public static function make($name, array $config)
//    {
//        $namespace = self::studly($name);
//        $application = "\\dubbo-client\\{$namespace}\\Application";
//
//        return new $application($config);
//    }
//
//    /**
//     * Convert a value to studly caps case.
//     *
//     * @param string $value
//     *
//     * @return string
//     */
//    public static function studly($value)
//    {
//        $key = $value;
//
//        if (isset(static::$studlyCache[$key])) {
//            return static::$studlyCache[$key];
//        }
//
//        $value = ucwords(str_replace(['-', '_'], ' ', $value));
//
//        return static::$studlyCache[$key] = str_replace(' ', '', $value);
//    }

}