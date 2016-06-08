<?php

namespace Main;

use Main\src\Bootstrap;

require 'Autoloader.php';
require 'Locator.php';

class Loader {

    protected $autoloader;
    protected $locators;

    public function __construct($config) {
        $this->setLocator('vendor', new Locator());
        $this->setLocator('service', new Locator());
        $this->setLocator('plugin', new Locator());

        $this->setAutoloader(new Autoloader($this->locators));

        $this->autoloadLibrary($config['library']);
        $this->autoloadVendor($config['vendor']);
        $this->autoloadFile('src/Bootstrap.php');

        new Bootstrap($this);
    }

    public function run() {
        $mvc = $this->getLocator('vendor')->get('Mvc');
        return $mvc->run();
    }

    public function autoloadVendor($autoloadArray) {
        $this->getAutoloader()->autoloadEmploys('vendor', $autoloadArray);
        $this->getLocator('vendor')->inject($this);
        $this->getLocator('vendor')->prepare();
    }

    public function autoloadLibrary($libraryConfig) {
        $this->getAutoloader()->autoloadLibrary($libraryConfig);
    }

    public function autoloadFile($file) {
        $this->getAutoloader()->autoloadFile(__DIR__.'/'.$file);
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
}

?>