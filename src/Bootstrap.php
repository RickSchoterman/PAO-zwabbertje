<?php

namespace Main\src;

use Main\Loader;

class Bootstrap {
    public function __construct(Loader $loader) {
        $vendorLocator = $loader->getLocator('vendor');
        $serviceLocator = $loader->getLocator('service');

        $userManager = $serviceLocator->get('User\Services\UserManager');
        $user = $userManager->getUser();

        $mvc = $vendorLocator->get('Mvc');
        $mvc->layoutModel->user = $user;
    }
}

?>