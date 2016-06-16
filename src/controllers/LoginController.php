<?php

namespace Main\src\Controller;

use Database\Services\EntityManager;
use Library\ControllerModel;
use Mvc\ViewModel;
use User\Authentication;

class LoginController extends ControllerModel {

    const LOGIN_ROUTE = 'account';

    const LOGIN_CALLBACK_ROUTE = _DEFAULT;

    const LOGOUT_CALLBACK_ROUTE = 'account/login';

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
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        $auth = new Authentication($this->getServiceLocator());
        if($user = $auth->authenticate($_POST['user'], md5($_POST['pass']))) {
            $userManager->login($user);
            $router->redirect(self::LOGIN_CALLBACK_ROUTE);
        }

        $router->redirect(self::LOGIN_ROUTE);
    }

    public function logoutAction() {
        $router = $this->getServiceLocator()->get('Router\Services\Router');
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        $userManager->logout();

        $router->redirect(self::LOGOUT_CALLBACK_ROUTE);
    }

    public function forgotAction() {
        if(isset($_POST['secret'])) {
            $email = $_POST['email'];
            $secret = md5($_POST['secret']);
            $password = md5($_POST['password']);
            $confirmPassword = md5($_POST['confirm_password']);

            /* @var $entityManager EntityManager */
            $entityManager = $this->getServiceLocator()->get('Database\Services\EntityManager');

            if($password == $confirmPassword) {
                $user = $entityManager->getRepository('User')->findOneBy(array(
                    'email' => $email,
                    'secret' => $secret,
                ));

                $user->setPassword($password);

                $entityManager->save($user);

                return array(
                    'form' => false,
                    'message' => 'Succesfully changed password',
                );
            }
        }
        
        return array(
            'form' => true,
            'message' => 'Enter your earlier given secret',
        );
    }
}

?>