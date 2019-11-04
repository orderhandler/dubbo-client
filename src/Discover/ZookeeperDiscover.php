<?php

namespace OrderHandler\Dubbo\Discover;


class ZookeeperDiscover{

    private $conf = [];

    private $zookeeper = null;

    public function __construct($discoverConfig){
        $this->conf = $discoverConfig;
    }

    /**
     * @param $name
     * @return bool|mixed
     *
     * service discover
     */
    public function loadProvider($name){
        if(is_null($this->zookeeper)){
            $this->zookeeper = new \Zookeeper($this->conf['url']);
        }
        $path = sprintf('/dubbo/%s/providers', $name);
        $rows = $this->zookeeper->getChildren($path);
        $providers = [];
        foreach ($rows as $row) {
            $info = parse_url(rawurldecode($row));

            $options = [];
            if (isset($info['query'])) {
                parse_str($info['query'], $options);
            }
            unset($info['query']);
            $info['options'] = $options;
            $info['options']['methods'] = explode(',', $info['options']['methods']);
            $providers[] = $info;
        }
        $num = count($providers);
        if ($num == 0) {
            return false;
        }
        if ($num > 1) {
            $index = mt_rand(0, $num - 1);
            $provider = $providers[$index];
        } else {
            $provider = $providers[0];
        }
        return $provider;
    }

//  public function random($size){

//      return time() % $size;
//  }

}
