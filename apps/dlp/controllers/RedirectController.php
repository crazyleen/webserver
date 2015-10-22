<?php
namespace Dlp\Controllers;

use \Phalcon\Mvc\Controller;

abstract class RedirectController extends Controller { 

    protected function redirect($path) {
        
        $this->view->disable();
        $this->response->redirect($path, true, 301);
        $this->response->send();      
    }
}
