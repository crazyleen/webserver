<?php
namespace Dlp\Models;

use \Dlp\Plugins\StrRand;
/**
 * 负责处理create_time，update_time
 */
class HceClient extends TimeModel {
    public $user_id; //用户 produceno
    public $sessionkey;
    public $imei;   //设备
    public $access_token; //用户的一个登录
    public $auth; //用户的一个登录
    
    public function initialize() {
        parent::initialize();

        $this->setConnectionService('db_hce');
        
        $this->belongsTo("user_id", "HceUser", "id");
    }
    
    public function getSource() {
        return 't_hce_client';
    }
    
    public static function findClient($uid, $imei) {
        $conditions = "imei = :imei: AND user_id = :uid:";
        $parameters = array(
                "imei" => $imei,
                "uid" => $uid,
        );
        return HceClient::findFirst(array(
                $conditions,
                "bind" => $parameters
        ));
    }

    public static function getClient($uid, $imei) {
    
        $m = HceClient::findClient($uid, $imei);
        if (!$m) {
            $m = new HceClient();
            if (!$m) {
                return;
            }
            $m->user_id = $uid;
            $m->imei = $imei;
            $m->auth = 0;
            $m->makeAccessToken();
            $m->save();
        }
        return $m;
    }
    
    public function updateAccessToken() {
        $accesstoken = $this->access_token;
        $this->makeAccessToken();
        return $accesstoken;
    }
    
    public static function getClientByToken($accesstoken) {
        $conditions = "access_token = :atoken:";
        $parameters = array(
                "atoken" => $access_token,
        );
        return HceClient::findFirst(array(
                $conditions,
                "bind" => $parameters
        ));
    }
    
    protected function makeAccessToken() {
        do {
            $this->access_token = StrRand::rand(32);
        } while (HceClient::findFirst("access_token = '" . $this->access_token . "'"));
    }
    
    public function getAccessTokenKey() {
        return $this->accessTokenKey($this->access_token);
    }
    
    public static function accessTokenKey($accesstoken) {
        return 'accesstoken:' . $accesstoken;
    }
}
