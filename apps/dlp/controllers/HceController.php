<?php
namespace Dlp\Controllers;
use \Dlp\Models\HceUser;
use \Dlp\Models\HceClient;

class HceController extends ResponseController
{
    /**
     * 首页
     */
    public function indexAction ()
    {

    }

    /**
     * 开通/关闭 HCE支付
     * POST /hce/open
     * sessionkey
     * productno
     * imei
     * state
     * 
     * redis set:  user:<uid>:state = state
     */
    public function openAction ()
    {
        // if (!$this->request->isPost()) {
        // $this->responseJsonFail(array('desc' => 'not post'));
        // return;
        // }
        
        $sessionkey = $this->request->get("sessionkey");
        $productno = $this->request->get("productno");
        $imei = $this->request->get("imei");
        
        $state = 0;
        if ($this->request->get("state"))
            $state = 1;
        
        if (!$productno || !$sessionkey || !$imei) {
            $this->responseJsonFail(array('desc' => '参数不完整'));
            return;
        }
        
        $rst = array();
        if ($this->getUserClient($productno, $imei) == true) {
            $this->user->state = $state;
            $this->client->auth = $state;
            $this->client->sessionkey = $sessionkey;
            if ($this->updateUserClient() == true) {
                $rst['data']['accesstoken'] = $this->client->access_token;
                $rst['data']['state'] = $this->user->state;
                $rst['data']['count'] = $this->countClients();
                $this->responseJsonSucc($rst);
                return;
            }
        }
        
        $this->responseJsonFail($rst);
    }

    /**
     * post /hce/sync
     * 同步
     */
    public function syncAction ()
    {
        // if (!$this->request->isPost()) {
        // $this->responseJsonFail(array('desc' => 'not post'));
        // return;
        // }
        $sessionkey = $this->request->get("sessionkey");
        $productno = $this->request->get("productno");
        $imei = $this->request->get("imei");
        
        if (!$productno || !$sessionkey || !$imei) {
            $this->responseJsonFail(array('desc' => '参数不完整'));
            return;
        }

        $rst = array();
        if ($this->getUserClient($productno, $imei) == true) {
            
            $this->client->sessionkey = $sessionkey;
            if ($this->updateClient() == true) {
                $rst['data']['accesstoken'] = $this->client->access_token;
                $rst['data']['state'] = $this->user->state;
                $rst['data']['auth'] = $this->client->auth;
                $this->responseJsonSucc($rst);
                return;
            }
        }
        
        $this->responseJsonFail($rst);
    }

    
    public function adminAction ()
    {
        $this->view->setVar("users", HceUser::find());
        $this->view->setVar("clients", HceClient::find());
    }

    private function countClients() 
    {
        $count = 0;
        if ($this->user->id) {
            $count = HceClient::count(array(
                "user_id = ?0 AND auth = 1",
                "bind" => array($this->user->id)));
        }
        return $count;
    }
    
    private function updateClient ()
    {
        // update accesstoken, old one timeout 10s, if close, delete it
        $key = $this->client->getAccessTokenKey();
        if ($this->user->state > 0)
            $this->redis->setTimeout($key, 10);
        else
            $this->redis->delete($key);
        
        $this->client->updateAccessToken();
        $this->updateRedis();
        return $this->client->save();
    }

    private function updateUserClient() {
        return ($this->user->save() == true && $this->updateClient() == true);
    }
    
    private function getUserClient($productno, $imei) {
        $this->user = HceUser::getUser($productno);
        if($this->user) {
            $this->client = HceClient::getClient($this->user->id, $imei);
            return true;
        }
        return false;
    }
    
    private function updateRedis() {
        if ($this->client && $this->user) {
            if ($this->user->state > 0) {
                $this->redis->set($this->user->getStateKey(), $this->user->state);
                $ackey = $this->client->getAccessTokenKey();
                $this->redis->set($ackey, $this->user->productno);
                $this->redis->setTimeout($ackey, 2592000); //30 days
            } else {
                $this->redis->delete($this->user->getStateKey());
            }
        }
    }
    
    private $user = null;
    private $client = null;
}
