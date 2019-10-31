<?php

namespace OrderHandler\Dubbo\Unserializer;

use OrderHandler\Dubbo\Constant\DubboInvokeConstant as DubboContent;

class TcpInvokeUnserializer{

    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

    public function decode($responseContent){
        var_dump($responseContent);
        exit;
        if(strstr($ret, self::DUBBO_NORMAL_END_FLAG)){
            $resArr= explode(self::DUBBO_NORMAL_END_FLAG, $ret);
            $res = trim($resArr[0]);
            return $res;
        }

        if ($ret === self::DUBBO_NULL_RESULT_FLAG) {
            throw new \RuntimeException("dubbo.nullResult : ".$ret);
        }

        if (strstr($ret, self::DUBBO_NO_SUCH_METHOD_FLAG)) {
            throw new \RuntimeException("dubbo.noMethod : ".$ret);
        }
        if (strstr($ret, self::DUBBO_NO_SUCH_SERVICE_FLAG)) {
            throw new \RuntimeException('dubbo.noService : '.$ret);
        }
        throw new \RuntimeException("dubbo.unknowError:" . $ret);

        return "";
    }

}
