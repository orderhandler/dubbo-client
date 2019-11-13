<?php

return [
    'registry' => [
        /**
         * 服务发现处理工具
         *
         */
        'type' => \OrderHandler\Dubbo\Discover\ZookeeperDiscover::class,
        /**
         * 默认的服务注册中心地址，一般这里的配置根据服务发现处理工具填写
         *
         */
        'url' => '127.0.0.1:2181',
    ],
    'logger' => [

        /**
         * 日志注入类，如果需要dubbo-client的debug日志，可以重写一个class，改这个配置即可
         * 默认是无输出的
         *
         */
        'class' => \OrderHandler\Dubbo\Logger\NoOutputLogger::class,
        'options' => [],
    ],
    'serializer' => [

        /**
         * 序列化类，将请求数据序列化，并发送给dubbo服务，如果需要支持别的协议，需要改写这里
         */
        'class' => \OrderHandler\Dubbo\Serializer\TcpInvokeSerializer::class,
    ],
    'unserializer' => [

        /**
         * 反序列化类，解析dubbo服务的返回报文，如果需要支持别的协议，需要改写这里
         *
         */
        'class' => \OrderHandler\Dubbo\Unserializer\TcpInvokeUnserializer::class,
    ],
    'connector' => [

        /**
         * 长链接使用工具，默认使用swoole-client,如果需要别的长链接工具，请改写这里
         *
         */
        'class' => \OrderHandler\Dubbo\Connector\SwooleTCPClient::class,
        /**
         * 这里就是swoole的配置了，具体项目请参考https://wiki.swoole.com/wiki/page/p-client.html
         *
         */
        'config' => [
            'open_eof_check' => true,
            'package_eof' => 'dubbo>',
            'package_max_length' => 1024 * 1024 * 8,
            'socket_buffer_size' => 1024 * 1024 * 8,
        ],
    ],
    /**
     * 这里是zookeeper上注册相关的，因为一些历史遗留问题，我们目前很多没用到，所以这里理论上有欠缺
     *
     */
    'options' => [
        'version' => null,
        'group' => null,
        'options' => [
            'charset' => 'utf-8'
        ],
    ],
];