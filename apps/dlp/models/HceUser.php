<?php
namespace Dlp\Models;

use Dlp\Models\HceClient;

/**
 * 负责处理create_time，update_time
 */
class HceUser extends TimeModel {
    public $productno;
    public $state;
    
    public function initialize() {
        parent::initialize();
        $this->setConnectionService('db_hce');
        
        $this->hasMany("id", "HceClient", "user_id");
    }
    
    public function getSource() {
        return 't_hce_user';
    }

    public static function findUser($productno) {
        
        $conditions = "productno = :productno:";
        $parameters = array(
                "productno" => $productno
        );
        return HceUser::findFirst(array(
                $conditions,
                "bind" => $parameters
            ));
    }
    
    public static function getUser($productno) {
        
        $user = HceUser::findUser($productno);
        if (!$user) {
            $user = new HceUser();
            if (!$user) {
                return;
            }
            $user->productno = $productno;
            $user->state = 0;
            $user->save();
        }
        return $user;
    }
    
    public function getStateKey() {
        return $this->stateKey($this->id);
    }
    
    public static function stateKey($uid) {
        return 'user:' . $uid . ':state';
    }
}
