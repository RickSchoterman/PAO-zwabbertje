<?php

namespace Messenger\Plugins;

use Library\EmployModel;

class Messenger {

    protected $messenger;

    public function __construct() {

    }

    public function __invoke($nameSpace) {
        return $this->messenger->getMessages($nameSpace);
    }

    public function inject(EmployModel $employ) {
        $this->messenger = $employ;
    }
}

?>