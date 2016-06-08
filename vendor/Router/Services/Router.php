<?php

namespace Router\Services;

use Library\EmployModel;

class Router {

    protected $employ;

    public function __construct() {

    }

    public function inject(EmployModel $employ) {
        $this->employ = $employ;
    }

    public function redirect($routeName) {
        $this->employ->redirect($routeName);
    }

}

?>