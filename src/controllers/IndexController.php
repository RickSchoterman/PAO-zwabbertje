<?php

namespace Main\src\Controller;

use Library\ControllerModel;
use Mvc\ViewModel;

class IndexController extends ControllerModel {
    public function indexAction() {
        $router = $this->getServiceLocator()->get('Router\Services\Router');
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        if(!$userManager->hasUser()) {
            $router->redirect('account');
        }

        return array(

        );
    }

    public function notFoundAction() {
        return array(

        );
    }
}

?>
