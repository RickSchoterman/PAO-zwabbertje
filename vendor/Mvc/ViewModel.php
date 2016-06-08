<?php

namespace Mvc;

class ViewModel {
    public function __construct($variables) {
        foreach($variables as $name => $value) {
            $this->$name = $value;
        }
    }

    public function __set($index, $value) {
        $this->$index = $value;
    }
}

?>