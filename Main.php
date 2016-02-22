<?php

require 'Autoloader.php';
require 'Locator.php';

class Main {

    protected $autoloader;
    protected $locators;
    protected $config;

    public function __construct($config) {
        $this->setAutoloader(new Autoloader());

        $this->setLocator('vendor', new Locator());
        $this->setLocator('service', new Locator());

        $this->setConfig($config);

        $this->autoloadVendor($config['vendor']);
        $this->autoloadServices($config['services']);
    }

    public function run() {
        $mvc = $this->getLocator('vendor')->get('Mvc');
        return $mvc->run();
    }

    public function autoloadVendor($autoloadArray) {
        $locator = $this->getAutoloader()->autoload('vendor', $this->getLocator('vendor'), $autoloadArray, true);
        $locator->inject($this);
        $this->setLocator('vendor', $locator);
    }

    public function autoloadServices($autoloadArray) {
        $locator = $this->getAutoloader()->autoload('src/services', $this->getLocator('service'), $autoloadArray, false);
        $this->setLocator('service', $locator);
    }

    /**
     * @return mixed
     */
    public function getAutoloader()
    {
        return $this->autoloader;
    }

    /**
     * @param mixed $autoloader
     */
    public function setAutoloader($autoloader)
    {
        $this->autoloader = $autoloader;
    }

    /**
     * @return mixed
     */
    public function getLocator($name)
    {
        return $this->locators[$name];
    }

    /**
     * @param mixed $locator
     */
    public function setLocator($name, $locator)
    {
        $this->locators[$name] = $locator;
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


}

?>