<?php

namespace Router\Plugins;

use Library\EmployModel;

class CurrentRoute {

    protected $router;

    public function __invoke($name) {
        $route = $this->router->getRouteByName($name);
        return $route == $this->router->getCurrentRoute();
    }

    public function inject(EmployModel $employ) {
        $this->router = $employ;
    }
}

?>