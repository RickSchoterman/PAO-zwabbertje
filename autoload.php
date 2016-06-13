<?php

namespace Main;

define('_DEFAULT', 0);
define('_ERROR', 404);

require 'Loader.php';

$config = array(
    'vendor' => require __DIR__ . '/config/vendor_config.php',
    'library' => require __DIR__ . '/config/library_config.php',
);

$website = new Loader($config);
echo $website->run();

?>