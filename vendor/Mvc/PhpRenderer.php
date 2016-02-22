<?php

class PhpRenderer {

    protected $viewModel;

    public function __construct(ViewModel $model) {
        $this->viewModel = $model;
    }

    public function __get($name) {
        return $this->viewModel->$name;
    }

    public function render($template) {
        $file = __DIR__.'/../../view/'.$template.'.phtml';

        if(!file_exists($file)) {
            throw new Exception('Template '.$template.' not found...');
        }

        ob_start();

        include __DIR__.'/../../view/'.$template.'.phtml';
        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}

?>