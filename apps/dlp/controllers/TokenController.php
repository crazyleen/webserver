<?php
namespace Dlp\Controllers;
use \Dlp\Plugins\Aes;
use \Dlp\Plugins\StrRand;
use Dlp\Models\HceUser;
use Dlp\Models\HceClient;

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
        if ($token) {
            $key = $this->tokenKey($token);
            $pan = $this->redis->get($key);
            
            //token被使用后必须3s内失效（防止网络不好posp重新查询）
            if ($this->redis->ttl($key) > 3)
                $this->redis->setTimeout($key, 3);
        }
        
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
        $accesstoken = $this->request->get("accesstoken");
        $token = $this->setToken($accesstoken);  

        $rst = array();
        $rst['data']['token'] = $token;
        if ($token)
            $this->responseJsonSucc($rst);
        else
            $this->responseJsonFail($rst);
    }

    private function setToken($accesstoken) {
        
        $pan = $this->redis->get(HceClient::accessTokenKey($accesstoken));
        if (!$pan) {
            return false;
        }
        
        $token = false;
        while (True) {
            $token = $this->gencode16();
            if ($this->redis->setnx($this->tokenKey($token), $pan)) {
                $this->redis->setTimeout($this->tokenKey($token), 60);
                break;
            }
            $this->logD('token', 'confilict');
        }
        return $token;
    }
    
    private function tokenKey($token)
    {
        return 'token:' . $token;
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
     * 生成16位基于时间的数字
     *
     * 开头是00001，2位时间（秒），中间8位是随机数，最后1位是校验码
     *
     * @return String 8位核销码
     */
    public static function gencode16()
    {
        $data = array(0,0,0);
        $sec = time() % 100;
        $rand = mt_rand(0, 99999999);
        return sprintf("00001%02d%08d%1d", $sec, $rand, ($rand + $sec) / 77 % 10);
    }
}
