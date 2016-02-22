<?php

class Locator {

    protected $library;

    public function __construct() {

    }

    public function add($name, $object) {
        $this->library[$name] = $object;
    }

    public function get($name) {
        return $this->library[$name];
    }

    public function attach($name, $arguments, $fn) {
        $class = $this->library[$name];
        $arguments = array_merge(array($class), $arguments);
        $this->library[$name] = call_user_func_array($fn, $arguments);
    }

    public function inject($main) {
        foreach($this->library as $name => $object) {
            $object->inject($main);
            $object->prepare();
        }
    }
}

?>