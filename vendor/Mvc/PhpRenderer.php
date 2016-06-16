<?php

namespace Mvc;

use Main\Locator;
use Mvc\Services\PluginManager;

class PhpRenderer {

    protected $pluginManger;
    protected $viewModel;

    public function __construct(ViewModel $model, PluginManager $pluginManger = null) {
        $this->pluginManger = $pluginManger;
        $this->viewModel = $model;
    }

    public function __call($func, $arguments) {
        $pluginManager = $this->pluginManger;
        if($pluginManager) {
            return call_user_func_array(array($pluginManager, $func), $arguments);
        }
    }

    public function __get($name) {
        if(isset($this->viewModel->$name)) {
            return $this->viewModel->$name;
        }

        return;
    }

    public function render($template) {
        $file = __DIR__.'/../../view/'.$template.'.phtml';

        if(!file_exists($file)) {
            throw new \Exception('Template '.$template.' not found...');
        }

        ob_start();

        include __DIR__.'/../../view/'.$template.'.phtml';
        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}

?>