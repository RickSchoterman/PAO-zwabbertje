<?php

class Router {

    protected $route;
    protected $routes;
    protected $notFoundRoute;

    protected $vendorLocator;

    public function __construct($routes) {
        $this->routes = $routes;
        $url = $_GET['url'];

        $route = $this->checkRoute($routes, $url);

        if($route) {
            $this->route = $route;
        }
    }

    public function inject(Main $main) {
        $vendorLocator = $main->getLocator('vendor');

        $this->setVendorLocator($vendorLocator);
    }

    public function prepare() {
        $executable = $this->route['executable'];

        $this->getVendorLocator()->attach('Mvc', array($executable, $this->route),
            function($self, $executables, $route) {
                if(isset($executables['controller']) && isset($executables['action'])) {
                    $self->setControllerName($executables['controller']);
                    $self->setActionName($executables['action']);
                } elseif(isset($executables['module'])) {
                    $self->setModuleName($executables['module']);
                    $self->setActionName($executables['action']);
                } else {
                    $this->exception('Route incomplete! Missing executables.');
                }

                if(isset($route['options'])) {
                    $options = $route['options'];

                    if(isset($options['layout'])) {
                        $self->layout = $options['layout'];
                    }
                }

                return $self;
            }
        );
    }

    protected function checkRoute($routes, $url) {
        foreach($routes as $name => $route) {
            if($name == '404') {
                $this->notFoundRoute = $route;
            }

            $routeName = $route['route'];

            $urlParams = split('/', $url);

            if($routeName == $urlParams[0]) {
                if(count($urlParams) > 1) {
                    $childRoutes = $route['child-routes'];
                    $route = $this->checkChildRoute($childRoutes, substr($url, strlen($urlParams[0])+1, strlen($url)));
                }

                return $route;
            }
        }

        if($this->notFoundRoute) {
            $this->redirect($this->notFoundRoute);
        }

        $this->exception('Route not found. 404route not set.');
    }

    protected function checkChildRoute($routes, $url) {
        foreach($routes as $name => $route) {
            $routeName = $route['route'];

            $urlParams = split('/', $url);

            if($routeName == $urlParams[0]) {
                if(count($urlParams) > 1) {
                    $childRoutes = $route['child-routes'];
                    $route = $this->checkChildRoute($childRoutes, substr($url, strlen($urlParams[0])+1, strlen($url)));
                }

                return $route;
            }
        }

        if($this->notFoundRoute) {
            $this->redirect($this->notFoundRoute);
        }

        $this->exception('Route not found. 404route not set.');
    }

    public function getRoute($name) {
        return $this->routes[$name];
    }

    public function redirect($route) {
        header('location: /'.$route['route'].' ');
    }

    public function exception($msg) {
        throw new Exception($msg);
    }

    /**
     * @return mixed
     */
    public function getVendorLocator()
    {
        return $this->vendorLocator;
    }

    /**
     * @param mixed $locator
     */
    public function setVendorLocator($vendorLocator)
    {
        $this->vendorLocator = $vendorLocator;
    }


}

?>