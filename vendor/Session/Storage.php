<?php

namespace Session;

class Storage {

    protected $className;

    public function __construct($className) {
        $this->className = $className;
    }

    public function get($index) {
        return $_SESSION[$this->className][$index];
    }

    public function set($index, $value) {
        $_SESSION[$this->className][$index] = $value;
    }

    public function reset($index) {
        unset($_SESSION[$this->className][$index]);
    }

    public function has($index) {
        return (isset($_SESSION[$this->className][$index]));
    }
}

?>