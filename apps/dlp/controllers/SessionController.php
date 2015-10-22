<?php 
namespace Dlp\Controllers;

use \Dlp\Company\Models\Company,
    \Dlp\Company\Models\Membership,
    \Dlp\Company\Models\Operator,
    \Dlp\Company\Models\Permission,
    \Dlp\Company\Models\Point,
    \Dlp\Models\StatusModel,
    \Dlp\Models\LogSession,
    \Dlp\Models\LogWrite;

abstract class SessionController extends LogController {

    public function initialize() {
        
    }

    protected function checkLogin() {

        if (isset($this->auth)) {
            return TRUE;
        }
        
        if ($this->session->has('auth')) {
            $this->auth = $this->session->get('auth');
            return TRUE;
        } else {
            return FALSE;
        }     
    }
    
}
// the script ends here with no PHP closing tag
