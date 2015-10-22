<?php
namespace Dlp\Test;
    
class Module implements \Phalcon\Mvc\ModuleDefinitionInterface {
    
    public function registerAutoloaders() {
        
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'Dlp\Plugins' => '../plugins',
            'Dlp\Controllers' => '../apps/dlp/controllers',
            'Dlp\Models' => '../apps/dlp/models',
            'Dlp\Test\Controllers' => '../apps/test/controllers',
            'Dlp\Test\Models' => '../apps/test/models'
        ));
        $loader->register();
    }
    
    public function registerServices($di) {

        $di->set('dispatcher', function() use ($di) {
        
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setDefaultNamespace('Dlp\Test\Controllers');
            return $dispatcher;
        });
        
        $di->set('view', function() {
            
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('./views');
            return $view;
        });

    }
}
// the script ends here with no PHP closing tag
