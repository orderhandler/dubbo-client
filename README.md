# dubbo-client
Dubbo client for php

## 使用方法

```php
require_once(__dir__ ."/../vendor/autoload.php");

$config = [
    'registry' => [
        'type' => \OrderHandler\Dubbo\Discover\ZookeeperDiscover::class,
        'url' => '127.0.0.1:2181',
    ],
    'options' => [
        'version' => null,
        'group' => null,
        'options' => [
            'charset' => 'utf-8'
        ],
    ],
];

$serviceName = 'com.member.MemberService';
$service = \OrderHandler\Dubbo\DubboClientFactory::make($serviceName, $config);
$req = [
    'memberId' => 1,
    'class' => 'com.member.MemberInfoRequestBO'
];
$res = $service->queryMemberInfo($req);

var_dump($res);

```

## 其它说明

1.目前没有增加dubbo各种协议。但是后续有计划补全
1.后期计划做个generator，可以根据接口直接生成对应的sdk，这样就不需要每次都加入classname和servicename了。但是还没排期
1.配置内容有很多，在``src/Configure.php``中可以看到默认项目


