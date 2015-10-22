<?php
use Phalcon\Mvc\Router,
    Phalcon\Mvc\Application,
    Phalcon\DI\FactoryDefault,
    Phalcon\Logger,
    Phalcon\Logger\Adapter\File;

error_reporting(E_ALL);
mb_internal_encoding('UTF-8');

$config = include('../configs/config.php');

$di = new FactoryDefault();
$di->set('host', $config->host);
$di->set('path', $config->path);
$di->set('config_db', $config->db);

$base_db_list = array('test');
foreach ($base_db_list as $db_name) {
    
    $di->set('db_' . $db_name, function() use($config, $db_name) {
        
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            'host' => $config->db->mysql->host,
            'username' => $config->db->mysql->username,
            'password' => $config->db->mysql->password,
            'charset' => $config->db->mysql->charset,
            'dbname' => $db_name,
            'options' => array(
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_STRINGIFY_FETCHES => false,
            )
        ));
    });
}

$di->set('router', function() {
    
    $router = new Router();
    
    $router->setDefaultModule('dlp');
    
    $router->add('/([a-zA-Z0-9_-]+)', array(
        'module' => 1,
        'controller' => 'index',
        'action' => 'index'
    ));

    $router->add('/:controller/:action', array(
        'module' => 'dlp',
        'controller' => 1,
        'action' => 2
    ));
    
    $router->add('/:module/:controller/:action', array(
        'module' => 1,
        'controller' => 2,
        'action' => 3
    ));

    return $router;
});

$di->setShared('session', function() {

    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});

try {
$app = new Application($di);

    $app->registerModules(array(
        'dlp' => array(
            'className' => 'Dlp\Module',
            'path' => '../apps/dlp/Module.php'
        ),
        'test' => array(
            'className' => 'Dlp\Test\Module',
            'path' => '../apps/test/Module.php'
        )
    ));
    
    echo $app->handle()->getContent();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}
