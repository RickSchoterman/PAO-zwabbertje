<?php

namespace Main;

class Locator {

    protected $library;

    public function __construct() {

    }

    public function add($name, $object) {
        $this->library[$name] = $object;
    }

    public function get($name) {
        if(isset($this->library[$name])) {
            return $this->library[$name];
        }
        
        throw new \Exception('Undifined service ' . $name);
    }

    public function getAll() {
        return $this->library;
    }

    public function byNamespace($namespace) {
        $data = array();

        foreach($this->library as $name => $object) {
            if(substr($name, 0, strlen($namespace)) == $namespace) {
                $data[$name] = $object;
            }
        }

        return $data;
    }

//    public function attach($name, $arguments, $fn) {
//        $class = $this->library[$name];
//        $arguments = array_merge(array($class), $arguments);
//        $this->library[$name] = call_user_func_array($fn, $arguments);
//    }

    public function inject($serviceLocator) {
        foreach($this->library as $name => $object) {
            $object->inject($serviceLocator);
            $object->injectEmploy();
        }
    }

    public function prepare() {
        foreach($this->library as $name => $object) {
            $object->prepare();
        }
    }
}

?>