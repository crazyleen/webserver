<?php
namespace Dlp\Test\Controllers;

use Dlp\Controllers\ResponseController;

class IndexController extends ResponseController {

    /**
     * 首页
     */
    public function indexAction() {        
        
        $this->view->disable();
        echo '<h1>test module index controler index action</h1>';
        $this->logD("test", "this is a test index");
    }

}
