<?php

namespace OrderHandler\Dubbo\Unserializer;

use OrderHandler\Dubbo\Constant\DubboInvokeConstant as DubboContent;

class TcpInvokeUnserializer{

    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

    /***
     * 获取响应报文，与dubbo的回复报文对比，取出返回的json内容
     * 解析json。
     * 如果报文中带有异常堆栈信息，直接抛出异常，附带内容。
     * 如果需要对异常进行处理，直接改造这段内容
     * TODO 异常处理注入点
     *
     * @param string $responseContent dubbo服务返回报文
     * @return array
     * @throws \RuntimeException
     */
    public function decode($responseContent){
        $ret= $responseContent;
        if(strstr($ret, DubboContent::DUBBO_NORMAL_END_FLAG)){
            $resArr= explode(DubboContent::DUBBO_NORMAL_END_FLAG, $ret);
            $res = trim($resArr[0]);
            return json_decode($res, 1);
        }

        if ($ret === DubboContent::DUBBO_NULL_RESULT_FLAG) {
            throw new \RuntimeException("dubbo.nullResult : ".$ret);
        }

        if (strstr($ret, DubboContent::DUBBO_NO_SUCH_METHOD_FLAG)) {
            throw new \RuntimeException("dubbo.noMethod : ".$ret);
        }
        if (strstr($ret, DubboContent::DUBBO_NO_SUCH_SERVICE_FLAG)) {
            throw new \RuntimeException('dubbo.noService : '.$ret);
        }
        throw new \RuntimeException("dubbo.unknowError:" . $ret);
    }

}
