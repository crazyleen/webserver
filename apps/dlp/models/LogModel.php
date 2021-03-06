<?php
namespace Dlp\Models;

use \Phalcon\Logger\Adapter,
    \Phalcon\Logger\Formatter;

/**
 * 负责输出日志
 */
abstract class LogModel extends Common {

	private function getLogger() {
        
        if (isset($this->logger)) {
            return $this->logger;
        }
        
        $date = date('Y-m-d');
        $this->logger = new Adapter\File("/data/www/logs/model-$date.log");
        $formatter = new Formatter\Line("[%type%] %message%");
        $this->logger->setFormatter($formatter);
        return $this->logger;
    }

    protected function logBegin() {

        $this->getLogger()->begin();
    }

    protected function logCommit() {

        $this->getLogger()->commit();
    }
    
    protected function logD($tag, $msg) {
        
        $time = date('H:i:s');
        $this->getLogger()->log("[$time] [$tag] $msg");
    }
    
    protected function logI($tag, $msg) {
        
        $time = date('H:i:s');
        $this->getLogger()->info("[$time] [$tag] $msg");
    }

    protected function logW($tag, $msg) {

        $time = date('H:i:s');
        $this->getLogger()->warning("[$time] [$tag] $msg");
    }

    protected function logE($tag, $msg) {

        $time = date('H:i:s');
        $this->getLogger()->error("[$time] [$tag] $msg");
    }
}
