<?php

namespace Session\Services;

use Library\EmployModel;
use Library\ServiceModel;
use Session\Storage;

class SessionManager implements ServiceModel {

    public function __construct() {

    }

    public function inject(EmployModel $employ) {

    }

    public function getStorage($obj) {
        return new Storage(get_class($obj));
    }
}

?>