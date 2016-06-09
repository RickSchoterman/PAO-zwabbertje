<?php

namespace Mvc\Services;

use Library\EmployModel;

class PluginManager {

    protected $pluginLocator;

    public function __construct() {

    }

    public function inject(EmployModel $employ) {
        $this->pluginLocator = $employ->getPluginLocator();
    }

    public function __call($pluginName, $arguments) {
        $plugins = $this->pluginLocator->getAll();

        foreach($plugins as $name => $plugin) {
            $lowerClassName = strtolower(substr($name, strlen($name)-strlen($pluginName), strlen($name)));
            if($lowerClassName == $pluginName) {
                return call_user_func_array(array($plugin, '__invoke'), $arguments);
            }
        }
    }
}

?>