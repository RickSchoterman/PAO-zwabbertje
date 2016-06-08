<?php

namespace Session;

use Library\EmployInterface;
use Library\EmployModel;

class Employ extends EmployModel implements EmployInterface {

    public function __construct($config) {
        ini_set('session.gc_maxlifetime', $config['timeout']);
        session_set_cookie_params($config['timeout']);

        $this->setConfig($config);
    }

    public function prepare() {
        session_start();
    }

    public function reset() {
        $_SESSION = array();
        session_destroy();
    }
}

?>