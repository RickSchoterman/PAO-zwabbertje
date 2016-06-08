<?php

namespace Library;

use Main\Loader;

class EmployModel {

    protected $config;

    protected $serviceLocator;
    protected $vendorLocator;
    protected $pluginLocator;

    public function inject(Loader $loader) {
        $serviceLocator = $loader->getLocator('service');
        $vendorLocator = $loader->getLocator('vendor');
        $pluginLocator = $loader->getLocator('plugin');
        $this->setServiceLocator($serviceLocator);
        $this->setVendorLocator($vendorLocator);
        $this->setPluginLocator($pluginLocator);
    }

    public function injectEmploy() {
        $namespace = str_replace('\Employ', '', get_class($this));

        $services = $this->getServiceLocator()->byNamespace($namespace);
        $plugins = $this->getPluginLocator()->byNamespace($namespace);

        foreach($services as $service) {
            $service->inject($this);
        }

        foreach($plugins as $plugin) {
            $plugin->inject($this);
        }
    }

    public function setData($data, $name) {
        $fileName = __DIR__.'/data/'.$name.'.php';

        $file = fopen($fileName, 'w');
        $writeSucces = fwrite($file, $data);
        $closeSucces = fclose($file);

        return ($writeSucces == true && $closeSucces == true);
    }

    public function getData($name) {
        $fileName = __DIR__.'/data/'.$name.'.php';

        return fopen($fileName, 'w') or die('Unable to open file!');
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

    /**
     * @return mixed
     */
    public function getPluginLocator()
    {
        return $this->pluginLocator;
    }

    /**
     * @param mixed $pluginLocator
     */
    public function setPluginLocator($pluginLocator)
    {
        $this->pluginLocator = $pluginLocator;
    }

}

?>