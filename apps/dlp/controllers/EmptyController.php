<?php
namespace Dlp\Controllers;

use \Phalcon\Mvc\Controller;

class EmptyController extends Controller {
    
    public function indexAction() {
        $this->response->setStatusCode(204, 'No Content');
    }
}
