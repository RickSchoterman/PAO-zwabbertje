<?php

namespace Main\src\Controller;

use Library\ControllerModel;
use Mvc\ViewModel;
use User\Authentication;

class LoginController extends ControllerModel {

    const LOGIN_CALLBACK_ROUTE = 'home';

    const LOGOUT_CALLBACK_ROUTE = 'login';

    public function indexAction() {
        $router = $this->getServiceLocator()->get('Router\Services\Router');

        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');
        if($userManager->hasUser()) {
            $router->redirect(self::LOGIN_CALLBACK_ROUTE);
        }

        return array();
    }

    public function loginAction() {
        $router = $this->getServiceLocator()->get('Router\Services\Router');
        //$sessionManager = $this->getServiceLocator()->get('Session\Services\SessionManager');
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        $auth = new Authentication($this->getServiceLocator());
        if($user = $auth->authenticate($_POST['user'], md5($_POST['pass']))) {
            //$sessionManager->getStorage($this)->set('user', $user);
            $userManager->login($user);
            $router->redirect(self::LOGIN_CALLBACK_ROUTE);
        }

        $router->redirect('login');
    }

    public function logoutAction() {
        $router = $this->getServiceLocator()->get('Router\Services\Router');
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        $userManager->logout();

        $router->redirect(self::LOGOUT_CALLBACK_ROUTE);
    }
}

?>