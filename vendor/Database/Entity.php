<?php

namespace Database;

class Entity {

    protected $table;
    public $tableName;

    public function __construct($tableName, $table) {
        $this->tableName = $tableName;
        $this->table = $table;
    }

    public function __call($name, $arguments) {
        $method = substr($name, 0, 3);
        $property = substr(lcfirst($name), 3, strlen($name));

        switch($method) {
            case 'set':
                $this->$property = $arguments[0];

                break;
            case 'get':
                return $this->$property;

                break;
        }
    }

    public function __get($name) {

        $tableName = '';
        $first = true;
        for($i=0; $i<strlen($name); $i++) {
            $char = $name[$i];

            if($first) {
                $tableName .= strtolower($char);
                $first = false;
                continue;
            }

            if(ctype_upper($char)) {
                $tableName .= '_'.strtolower($char);
            } else {
                $tableName .= $char;
            }
        }

        return $this->table[$tableName];
    }

    public function __set($name, $value) {
        if(array_key_exists($name, $this->table)) {
            $this->table[$name] = $value;
        } else {
            echo 'undefined property '.$name;
        }
    }

    public function __properties() {
        return $this->table;
    }
}

?>