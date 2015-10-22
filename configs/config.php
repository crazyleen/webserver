<?php
return new \Phalcon\Config(array(
    'path' => array(
        'root' => '/data/web',
        'public' => '/data/web/public',
        'img_tmp' => '/data/web/public/img/tmp'
    ),
    'db' => array(
        'mysql' => array(
            'adapter'  => 'Mysql',
            'host'     => 'guang-mysql',
            'username' => 'root',
            'password' => 'rootguang',
            'charset'  => 'utf8'
        )
    ),
    'host' => array(
        'static' => 'http://192.168.14.90'
    ),
));
