<?php

namespace OrderHandler\Dubbo\Discover;


class ZookeeperDiscover{

    private $conf = [];

    private $zookeeper = null;

    /**
     * ZookeeperDiscover constructor.
     * @param $discoverConfig 服务注册中心地址
     *
     */
    public function __construct($discoverConfig){
        $this->conf = $discoverConfig;
    }

    /**
     *
     * 从服务发现中心查找服务提供者的IP，端口号
     *
     * @param $name
     * @return array
     *
     */
    public function loadProvider($name)
    {

        if(is_null($this->zookeeper)){
            $this->zookeeper = new \Zookeeper($this->conf['url']);
        }
        $path = sprintf('/dubbo/%s/providers', $name);
        $rows = $this->zookeeper->getChildren($path);

        $providers = $this->dataCompose($rows);

        $num = count($providers);
        if ($num == 0) {

            throw new \RuntimeException("service not found");
        }
        if ($num > 1) {

            $provider = $this->loadBalance($providers);
        } else {
            $provider = $providers[0];
        }

        return $provider;
    }


    /**
     * 处理服务发现中心获取到的服务提供者信息
     *
     * @param $data
     * @return array
     *
     */
    private function dataCompose($data)
    {

        $providers = [];
        foreach ($data as $row) {
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

        return $providers;
    }

    /**
     *
     * 如果发现多个服务则做负载均衡
     *
     * @param $providers
     * @return array
     */
    private function loadBalance($providers){

        $index = mt_rand(0, count($providers) - 1);
        $provider = $providers[$index];

        return $provider;
    }

}
