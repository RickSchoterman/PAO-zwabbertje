<?php

namespace Mvc;

use Library\EmployInterface;
use Library\EmployModel;
use Main\Main;

class Employ extends EmployModel implements EmployInterface {

    protected $controllerName;
    protected $actionName;
    protected $moduleName;

    public $layoutModel;

    public $layout = 'layout/layout';

    public function __construct($config) {
        $this->setConfig($config);
        $this->layoutModel = new ViewModel(array());
    }

    public function prepare() {

    }

    public function run() {
        $config = $this->getConfig();

        if($this->getControllerName() && $this->getActionName()) {
            return $this->runController($this->getControllerName(), $this->getActionName());
        } elseif($this->getModuleName() && $this->getActionName()) {
            return $this->runModule($this->getModuleName(), $this->getActionName());
        } else {
            $url = $_GET['url'];
            $urlParams = split('/', $url);

            if(count($urlParams) == 2) {
                $controllerName = $urlParams[0];
                $actionName = $urlParams[1];
            } else {
                if(isset($config['default'])) {
                    $controllerName = $config['default']['controller'];
                    $actionName = $config['default']['action'];
                } else {
                    throw new \Exception('Default controller and action must be set!');
                }
            }

            return $this->runController($controllerName, $actionName);
        }
    }

    public function runController($controllerName, $actionName) {
        $controllerClassName = $controllerName.'Controller';
        $actionMethodName = $actionName.'Action';

        include __DIR__ . '/../../src/Controllers/' . $controllerClassName . '.php';

        /*echo $controllerClassName; exit;*/

        $controllerNamespace = 'Main\src\Controller\\'.ucfirst($controllerClassName);
        $controllerClass = new $controllerNamespace($this->getServiceLocator());

        $output = $controllerClass->$actionMethodName();

        $template = strtolower($controllerName).'/'.$actionName;

        return $this->buildLayout($output, $template);
    }

    public function runModule($moduleName, $action) {
        include __DIR__ . '/../../src/Modules/' .ucfirst($moduleName).'.php';

        $moduleClassName = ucfirst($moduleName);
        $moduleClass = new $moduleClassName($this->getServiceLocator());
        $output = $moduleClass->$action();

        $template = strtolower('Modules/'.$moduleName.'/'.$action);

        return $this->buildLayout($output, $template);
    }

    public function buildLayout($output, $template) {
        if($output instanceof ViewModel) {
            $contentModel = $output;
        } else {
            $contentModel = new ViewModel($output);
        }

        $pluginManager = $this->getServiceLocator()->get('Mvc\Services\PluginManager');

        $contentRenderer = new PhpRenderer($contentModel, $pluginManager);

        $this->layoutModel->content = $contentRenderer->render($template);

        $layout = new PhpRenderer($this->layoutModel, $pluginManager);
        return $layout->render($this->layout);
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param mixed $actionName
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param mixed $controllerName
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return mixed
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * @param mixed $moduleName
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }
}

?>