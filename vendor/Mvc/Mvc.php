<?php

class Mvc {
    protected $controllerName;
    protected $actionName;
    protected $moduleName;

    protected $config;

    protected $vendorLocator;
    protected $serviceLocator;

    public $layout = 'layout/layout';

    public function __construct($config) {
        $this->setConfig($config);
    }

    public function inject(Main $main) {
        $vendorLocator = $main->getLocator('vendor');
        $serviceLocator = $main->getLocator('service');

        $this->setVendorLocator($vendorLocator);
        $this->setServiceLocator($serviceLocator);
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
                $controllerName = $config['default']['controller'];
                $actionName = $config['default']['action'];
            }

            return $this->runController($controllerName, $actionName);
        }
    }

    public function runController($controllerName, $actionName) {
        $controllerClassName = $controllerName.'Controller';
        $actionMethodName = $actionName.'Action';

        include __DIR__.'/../../src/controllers/'.$controllerClassName.'.php';
        $controllerClass = new $controllerClassName($this->getServiceLocator());

        $output = $controllerClass->$actionMethodName();

        $template = strtolower($controllerName).'/'.$actionName;

        return $this->buildView($output, $template);
    }

    public function runModule($moduleName, $action) {
        include __DIR__.'/../../src/modules/'.ucfirst($moduleName).'.php';

        $moduleClassName = ucfirst($moduleName);
        $moduleClass = new $moduleClassName($this->getServiceLocator());
        $output = $moduleClass->$action();

        $template = strtolower('modules/'.$moduleName.'/'.$action);

        return $this->buildView($output, $template);
    }

    public function buildView($output, $template) {
        if($output instanceof ViewModel) {
            $contentModel = $output;
        } else {
            $contentModel = new ViewModel($output);
        }

        $contentRenderer = new PhpRenderer($contentModel);

        $layoutModel = new ViewModel(array(
            'content' => $contentRenderer->render($template),
        ));

        $layout = new PhpRenderer($layoutModel);
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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
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

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param mixed $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }


}

?>