<?php
require_once(__dir__ ."/../vendor/autoload.php");

$config = [
    'registry' => [
        'type' => \OrderHandler\Dubbo\Discover\ZookeeperDiscover::class,
        'url' => '192.168.2.23:2181',
    ],
    'options' => [
        'version' => null,
        'group' => null,
        'options' => [
            'charset' => 'utf-8'
        ],
    ],
    'logger' => [
        'class' => \OrderHandler\Dubbo\Logger\EchoLogger::class,
        'options' => [],
    ],

];



$serviceName = 'com.lf.member.nav.member.MemberService';



$service = \OrderHandler\Dubbo\DubboClientFactory::make($serviceName, $config);
$req = [
    'memberId' => 1,
    'class' => 'com.lf.member.bo.request.MemberInfoRequestBO'
];
$res = $service->queryMemberInfo($req);

var_dump($res);



