<?php

namespace OrderHandler\Dubbo\Connector;

class SwooleTCPClient{

    private $provider = [];

    private $options = [];

    private $config = [];

    private $conn = null;

    /**
     * SwooleTCPClient constructor.
     * @param $provider 从服务发现中心获取的服务提供者的信息
     * @param $options  字节编码的配置信息
     * @param $config   swoole_client配置
     *
     */
    public function __construct($provider, $options, $config){
        $this->provider = $provider;
        $this->options = $options;
        $this->config = $config;
    }



    /***
     *
     * 对服务器做报文交换，默认使用swoole
     *
     * @param $requestContent
     * @return string
     * @throw RuntimeException
     *
     */
    public function send($requestContent){

        if($this->conn == null  || !$this->conn->isConnected()){

            $this->init();
        }
        $this->conn->send($requestContent . "\n");
        $ret = $this->conn->recv();
        return $ret;
    }

    public function __destruct(){
        if($this->conn != null && $this->conn->isConnected()){
            $this->conn->close();
        }
    }

    /**
     * 初始化swoole client
     *
     */
    private function init(){

        $provider = $this->provider;
        $this->conn = new \swoole_client(SWOOLE_SOCK_TCP);
        $this->conn->set(
            $this->config['Config']
        );
        if (!$this->conn->connect($provider['host'], $provider['port'], -1))
        {
            throw new \RuntimeException("connect failed. Error: {$this->conn->errCode}\n");
        }
    }

}


