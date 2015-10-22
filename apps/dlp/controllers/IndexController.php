<?php
namespace Dlp\Controllers;

class IndexController extends RedirectController {

    /**
     * 首页
     */
    public function indexAction() {        
        
        $this->view->disable();
        echo '<h1>hello world</h1>';
    }

}
