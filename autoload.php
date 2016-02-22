<?php

require 'Main.php';

$config = require __DIR__.'/config/main_config.php';

$website = new Main($config);
echo $website->run();

?>