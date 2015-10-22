<?php
namespace Dlp\Models;

/**
 * 负责处理create_time，update_time
 */
abstract class TimeModel extends LogModel {

    public function beforeValidationOnCreate() {

        $this->create_time = $_SERVER['REQUEST_TIME'];
        $this->update_time = $_SERVER['REQUEST_TIME'];
    }

    public function beforeValidationOnUpdate() {

        $this->update_time = $_SERVER['REQUEST_TIME'];
    }

    public function createTimeInfo() {

        return date('Y-m-d H:i:s', $this->create_time);
    }
    
    public function updateTimeInfo() {
        
        return date('Y-m-d H:i:s', $this->update_time);
    }
}
