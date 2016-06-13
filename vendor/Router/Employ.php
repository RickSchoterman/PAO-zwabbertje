<?php

namespace Router;

use Library\EmployInterface;
use Library\EmployModel;
use Main\Main;

class Employ extends EmployModel implements EmployInterface {

    protected $route;
    protected $notFoundRoute;

    public function __construct($config) {
        $this->setConfig($config);
        $url = $_GET['url'];

        $route = $this->getRouteByUrl($url);

        if(!$route) {
            if($url == '') {
                
                if(isset($config[_DEFAULT])) {
                    $this->route = $config[_DEFAULT];
                }
                
            } else if($this->notFoundRoute) {
                
                $this->route = $this->notFoundRoute;
                
            }
        }

        if($route) {
            $this->route = $route;
        }
    }

    public function prepare() {
        $executables = $this->route['executable'];

        $mvc = $this->getVendorLocator()->get('Mvc');

        if(isset($executables['controller']) && isset($executables['action'])) {
            $mvc->setControllerName(ucfirst($executables['controller']));
            $mvc->setActionName(ucfirst($executables['action']));
        } elseif(isset($executables['module'])) {
            $mvc->setModuleName($executables['module']);
            $mvc->setActionName($executables['action']);
        } else {
            throw new \Exception('Route incomplete! Missing executables.');
        }

        if(isset($this->route['options'])) {
            $options = $this->route['options'];

            if(isset($options['layout'])) {
                $mvc->layout = $options['layout'];
            }
        }
    }

    public function getRouteByName($routeName) {
        $routes = $this->getConfig();

        $splitedName = explode('/', $routeName);

        foreach ($splitedName as $key => $routeName) {
            $route = $routes[$routeName];

            if(count($splitedName) == ($key+1)) {
                return $route;
            } else if(isset($route['child-routes'])) {
                $routes = $route['child-routes'];
            } else {
                \Exception('Could not find route with name: "'. $routeName .'"');
            }
        }
    }

    protected function getRouteByUrl($url) {
        $routes = $this->getConfig();

        foreach($routes as $name => $route) {
            if($name == _ERROR) {
                $this->notFoundRoute = $route;
            }

            $routeName = $route['route'];

            $urlParams = explode('/', $url);

            if($routeName == $urlParams[0]) {
                if(count($urlParams) > 1) {
                    $childRoutes = $route['child-routes'];
                    $route = $this->getChildRouteByUrl($childRoutes, substr($url, strlen($urlParams[0])+1, strlen($url)));
                }

                return $route;
            }
        }
    }

    public function getUrlByName($routeName) {
        $routes = $this->getConfig();

        $url = '';

        $splitedName = explode('/', $routeName);

        foreach ($splitedName as $key => $routeName) {
            $route = $routes[$routeName];

            $url .= '/' . $route['route'];

            if(count($splitedName) == ($key+1)) {
                return $url;
            } else if(isset($route['child-routes'])) {
                $routes = $route['child-routes'];
            } else {
                \Exception('Could not find route with name: "'. $routeName .'"');
            }
        }
    }

    protected function getChildRouteByUrl($routes, $url) {
        foreach($routes as $name => $route) {
            $routeName = $route['route'];

            $urlParams = explode('/', $url);

            if($routeName == $urlParams[0]) {
                if(count($urlParams) > 1) {
                    $childRoutes = $route['child-routes'];
                    $route = $this->checkChildRoute($childRoutes, substr($url, strlen($urlParams[0])+1, strlen($url)));
                }

                return $route;
            }
        }
    }

    public function getRoute($name) {
        return $this->config[$name];
    }

    public function getCurrentRoute() {
        return $this->route;
    }

    public function redirect($routeName) {
        $url = $this->getUrlByName($routeName);
        header('location: ' . $url . ' ');
    }

    public function exception($msg) {
        throw new \Exception($msg);
    }
}

?>