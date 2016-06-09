<?php

namespace Router\Plugins;

use Library\EmployModel;

class Url {

    protected $router;

    public function __construct() {

    }

    public function __invoke($name) {
        $url = $this->router->getUrlByName($name);
        return $url;
    }

    public function inject(EmployModel $employ) {
        $this->router = $employ;
    }
}

?>