<?php

class ViewModel {

    public function __construct($variables) {
        foreach($variables as $name => $value) {
            $this->$name = $value;
        }
    }
}

?>