<?php

namespace Main;

require 'Loader.php';

$config = array(
    'vendor' => require __DIR__ . '/config/vendor_config.php',
    'library' => require __DIR__ . '/config/library_config.php',
);

$website = new Loader($config);
echo $website->run();

?>