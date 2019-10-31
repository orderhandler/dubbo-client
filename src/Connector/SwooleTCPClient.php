<?php

namespace OrderHandler\Dubbo\Connector;

class SwooleTCPClient{

    private $provider = [];

    private $options = [];

    private $config = [];

    private $conn = null;

    public function __construct($provider, $options, $config){
        $this->provider = $provider;
        $this->options = $options;
        $this->config = $config;
    }


    public function send($requestContent){
        $provider = $this->provider;
        if($this->conn == null  || !$this->conn->isConnected()){
            $this->conn = new \swoole_client(SWOOLE_SOCK_TCP);
            $this->conn->set(
                $this->config['config']
            );
            if (!$this->conn->connect($provider['host'], $provider['port'], -1))
            {
                throw new \RuntimeException("connect failed. Error: {$this->conn->errCode}\n");
            }

        }
        $this->conn->send($requestContent . "\n");
        $ret = $this->conn->recv();
        return $ret;
    }

    public function __destruct(){

    }

}


