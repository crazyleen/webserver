<?php
namespace Dlp\Controllers;
use \Dlp\Plugins\Aes;

class TokenController extends ResponseController
{

    private $tokenpankey = "token:";

    /**
     * 首页
     */
    public function indexAction ()
    {
        $this->view->disable();
        echo '<h1>HCE TOKEN SYSTEM</h1>';
    }

    /**
     * pos通过token查询pan接口
     * get /token/query?token=24141141431242141
     */
    public function queryAction ()
    {
        // TODO: ip white list
        $pan = false;
        $token = $this->request->get("token");
        $key = $this->tokenpankey . $token;
        if ($token)
            $pan = $this->redis->get($key);
        if ($pan)
            $this->redis->delete($key);
        
        $rst = array(
                "token" => $token,
                "pan" => $pan
        );
        $this->responseJson($rst);
        // echo Aes::encode($this->posp->key, json_encode($rst));
    }

    public function updateAction ()
    {
        $token = false;
        $pan = $this->request->get("pan");
        $rst = array();
        $rst['pan'] = $pan;
        $rst['token'] = null;
        $rst['used'] = 0;
        if ($pan) {
            for ($i = 0; $i < 10000; $i ++) {
                $token = $this->getToken($pan);
                $key = $this->tokenpankey . $token;
                if ($this->redis->setnx($key, $pan)) {
                    $this->redis->setTimeout($key, 60);
                    $rst['token'] = $token;
                    break;
                }
                $rst['used'] += 1;
            }
        }
        $this->responseJson($rst);
    }

    private function getToken ($pan)
    {
        return mt_rand(100, 105) . $pan . 'xxx';
    }

    private function performanceAction ()
    {
        $uid = $this->redis->incr("grobal:next_uid");
        $uid = sprintf("uid:%d:code", $uid);
        $name = $this->generateCode();
        $this->redis->set($uid, $name);
        
        $result = array(
                "code" => $this->redis->get($uid),
                "uid" => $uid
        );
        $this->responseJson($result);
    }

    /**
     * 生成核销码
     *
     * 核销码是36进制的8位数
     * 前3位是天数，中间4位是随机数，最后1位是校验码
     *
     * @return String 8位核销码
     */
    private static function generateCode ()
    {
        $days = intval(time() / (24 * 3600)) % (36 * 36 * 36);
        $code = '';
        $array = array();
        for ($i = 0; $i < 3; $i ++) {
            $array[$i] = $days % 36;
            $code .= self::toBase36Digit($array[$i]);
            $days = intval($days / 36);
        }
        for ($i = 3; $i < 7; $i ++) {
            $array[$i] = mt_rand(0, 35);
            $code .= self::toBase36Digit($array[$i]);
        }
        
        $code .= self::toBase36Digit(
                ($array[0] * 2 + $array[1] * 5 + $array[2] * 8 + $array[3] * 3 +
                         $array[4] * 7 + $array[5] * 4 + $array[6] * 6) % 36);
        return $code;
    }

    /**
     *
     * @param
     *            Integer num 0~35
     * @return String '0'~'9','a'~'z'
     */
    private static function toBase36Digit ($num)
    {
        if ($num < 10) {
            return chr(ord('0') + $num);
        }
        $num = $num - 10;
        if ($num < 26) {
            return chr(ord('a') + $num);
        }
        return '';
    }
}
