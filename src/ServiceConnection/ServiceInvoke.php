<?php
/**
 * Created by IntelliJ IDEA.
 * User: bella
 * Date: 2019-10-22
 * Time: 17:53
 */

namespace Orderhandler\Dubbo\ServiceConnection;


class ServiceInvoke
{

    private $serializer = [];

    private $connecror = [];

    private $unserializer = [];

    private $logger = [];

    public function setLogger(LoggerInstance $logger){
        $this->logger  = $logger;
    }

    public function __construct(LoggerInstance $logger, $provider)
    {
        $this->logger = $logger;
    }

    public function __call($method, $args){
        return $this->invoke($provider, $method, $args);
    }

    public function call($method, $args){
        $this->logger->error($msg, $exception);
        $this->logger->info($msg);

        $connector->write($req);
        $res = '';
        $connector->read($res);

        $this->logger->debug("reponse is : " . $res);
        $result = $this->unserializer->exec($res);
    }


    public function invoke($provider, $method, $args){

        $timeout = isset($provider['options']['timeout']) ? $provider['options']['timeout'] / 1000 : 5;
        $args = json_encode($args);
        $args = substr($args, 1, -1);
        $cmd = sprintf("invoke %s.%s(%s)", $provider['options']['interface'], $method, $args);

        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        $client->set([
            'open_eof_check' => true,
            'package_eof' => self::DUBBO_HINT_FLAG,
            'package_max_length' => 1024 * 1024 * 8,
            'socket_buffer_size' => 1024 * 1024 * 8,
        ]);
        if (!$client->connect($provider['host'], $provider['port'], -1))
        {
            throw new \RuntimeException("connect failed. Error: {$client->errCode}\n");
        }
        $client->send($cmd . "\n");
        $ret = $client->recv();
        $client->close();

        return $ret;
    }
}