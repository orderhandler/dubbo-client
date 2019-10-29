<?php
/**
 * Created by IntelliJ IDEA.
 * User: bella
 * Date: 2019-10-22
 * Time: 15:39
 */

namespace Orderhandler\Dubbo\DiscoverService;

class ServiceProvider
{


    public function __construct($service, $method)
    {
        return $this->getProvider($service, $method);
    }

    /**
     * Zookeeper's instance
     * @var \Zookeeper
     */
    private $zoo;
    /**
     * Registry's address
     * @var string
     */
    private $registry = '127.0.0.1:2181';

    private function getProvider($service, $method) {
        if (!$this->zoo) {
            $this->zoo = new \Zookeeper($this->registry);
        }
        $path = sprintf('/dubbo/%s/providers', $service);
        $rows = $this->zoo->getChildren($path);
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
            if (!in_array($method, $info['options']['methods'])) {
                continue;
            }

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

}