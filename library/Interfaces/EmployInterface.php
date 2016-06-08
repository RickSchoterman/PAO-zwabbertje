<?php

namespace Library;

use Main\Loader;

interface EmployInterface {
    public function __construct($config);

    public function inject(Loader $loader);

    public function prepare();
}

?>