<?php
/**
 * Created by IntelliJ IDEA.
 * User: bella
 * Date: 2019-10-22
 * Time: 17:57
 */

namespace Orderhandler\Dubbo\ServiceConnection;


class ContentAnalyze
{

    const DUBBO_NO_SUCH_METHOD_FLAG = 'No such method ';
    const DUBBO_NO_SUCH_SERVICE_FLAG = 'No such service ';
    const DUBBO_NORMAL_END_FLAG = 'elapsed: ';
    const DUBBO_NULL_RESULT_FLAG = "null\r\n";
    const DUBBO_HINT_FLAG = 'dubbo>';


    public function __construct($content)
    {

        return $this->messageHandler($content);
    }

    private function messageHandler($content){

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
    }


}