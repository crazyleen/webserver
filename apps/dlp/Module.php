<?php
namespace Dlp;

class Module implements \Phalcon\Mvc\ModuleDefinitionInterface {
    
    public function registerAutoloaders() {
        
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'Dlp\Plugins' => '../plugins',
            'Dlp\Controllers' => '../apps/dlp/controllers',
            'Dlp\Models' =>  '../apps/dlp/models',
        ));
        $loader->register();
    }
    
    public function registerServices($di) {

        $config_db = $di->get('config_db');

        $db_list = array('weixin', 'device', 'application');
        foreach ($db_list as $db_name) {
            $di->set('db_' . $db_name, function() use($config_db, $db_name) {
                return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                    'host' => $config_db->mysql->host,
                    'username' => $config_db->mysql->username,
                    'password' => $config_db->mysql->password,
                    'charset' => $config_db->mysql->charset,
                    'dbname' => $db_name,
                    'options' => array(
                        \PDO::ATTR_EMULATE_PREPARES => false,
                        \PDO::ATTR_STRINGIFY_FETCHES => false,
                    )
                ));
            });
        }
        
        $di->set('dispatcher', function() {
            
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setDefaultNamespace('Dlp\Controllers');
            return $dispatcher;
        });

        $di->set('view', function() {
    
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('./views');
            $view->registerEngines(array(
                '.phtml' => '\Phalcon\Mvc\View\Engine\Volt'
            ));  
            return $view;
        });       
        
        $di->setShared('session', function() {
        
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });
    }
}
// the script ends here with no PHP closing tag
