<?php

namespace OrderHandler\Dubbo\Unserializer;

use OrderHandler\Dubbo\Constant\DubboInvokeConstant as DubboContent;

class TcpInvokeUnserializer{

    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

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
