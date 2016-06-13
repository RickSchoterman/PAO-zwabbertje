<?php

namespace Main;

class Autoloader {

    protected $loaded = array();
    protected $locators;

    protected $currentEmploy;
    protected $currentEmployNamespace;

    public function __construct($locators) {
        $this->locators = $locators;
    }

    public function autoloadEmploys($path, $modules) {
        foreach($modules as $employ => $config) {
            if($this->isLoaded($employ)) {
                continue;
            }

            $modulePath = __DIR__ . '/' . $path.'/'.$employ;

            $this->includePath($modulePath);

            $employObjectName = $employ.'\Employ';
            $this->currentEmployNamespace = $employ;
            $this->currentEmploy = new $employObjectName($config);
            $this->locators['vendor']->add($employ, $this->currentEmploy);

            if(is_dir($modulePath.'/Services')) {
                $this->includePath($modulePath.'/Services', function($serviceName) {
                    $serviceObjectName = $this->currentEmployNamespace.'\Services\\'.$serviceName;
                    $this->locators['service']->add($serviceObjectName, new $serviceObjectName());
                });
            }

            if(is_dir($modulePath.'/Plugins')) {
                $this->includePath($modulePath.'/Plugins', function($pluginName) {
                    $pluginObjectName = $this->currentEmployNamespace.'\Plugins\\'.$pluginName;
                    $this->locators['plugin']->add($pluginObjectName, new $pluginObjectName());
                });
            }

            $this->isLoaded($employ, true);

            $this->currentEmploy = null;
        }
    }

    public function autoloadLibrary($libraryConfig, $libraryDir = 'library') {
        foreach($libraryConfig as $dir => $files) {
            foreach($files as $file) {
                $this->autoloadFile($libraryDir.'/'.$dir.'/'.$file.'.php');
            }
        }
    }

    public function autoloadFile($file) {
        include $file;
    }

    public function isLoaded($module, $boolean = null) {
        if(!is_null($boolean)) {
            $this->loaded[] = $module;
            return;
        }

        if(in_array($module, $this->loaded)) {
            return true;
        }

        return false;
    }

    public function includePath($path, $callback = null) {
        $dir = scandir($path);
        foreach($dir as $file) {
            if (substr($file, 0, 1) == '.') {
                continue;
            }

            if(is_dir($path.'/'.$file)) {
                continue;
            }

            include $path.'/'.$file;

            if($callback) {
                $file = pathinfo($path.'/'.$file);
                $callback($file['filename']);
            }
        }
    }
}

?>