<?php
namespace Dlp\Models;

/**
 * 负责处理create_time，update_time
 */
class Test extends TimeModel {
    public function initialize() {
        parent::initialize();

        $this->setConnectionService('db');
    }
    public function hello() {
        return 'this is test module';
    }
}
