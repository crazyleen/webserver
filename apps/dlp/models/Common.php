<?php
namespace Dlp\Models;

/**
 * 用于继承 Model，规定使用UTF-8 编码
 */
abstract class Common extends \Phalcon\Mvc\Model {
    
    public function initialize() {
        
        mb_internal_encoding('UTF-8');
    }
    
    public function getErrMsg() {
        $msg = "DB[" . $this->getSource() . "]";
        foreach ($this->getMessages() as $message) {
            $msg = $msg . "(". $message->getMessage() . ")";
        }
        return $msg;
    }
}
// the script ends here with no PHP closing tag
