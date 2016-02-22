<?php

class Autoloader {

    protected $loaded = array();

    public function __construct() {

    }

    public function autoload($path, $locator, $modules, $nested = false) {
        foreach($modules as $module => $config) {
            if($this->isLoaded($module)) {
                continue;
            }

            $modulePath = __DIR__.'/'.$path.'/'.$module;

            if($nested) {
                $moduleDir = scandir($modulePath);

                foreach($moduleDir as $file) {
                    if (substr($file, 0, 1) == '.') {
                        continue;
                    }

                    include $modulePath.'/'.$file;
                }
            } else {
                include __DIR__.'/'.$path.'/'.$module.'.php';
            }

            $locator->add($module, new $module($config));
            $this->isLoaded($module, true);
        }

        return $locator;
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
}

?>