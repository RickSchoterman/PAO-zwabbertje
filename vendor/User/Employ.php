<?php

namespace User;

use Library\EmployInterface;
use Library\EmployModel;

class Employ extends EmployModel implements EmployInterface {

    protected $userTable;

    protected $serviceLocator;
    
    protected $entityManager = 'Database\Services\EntityManager';

    public function __construct($config) {
        $this->setConfig($config);
        $this->userTable = $config['table'];
    }

    public function prepare() {
        $sessionManager = $this->getServiceLocator()->get('Session\Services\SessionManager');
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        $storage = $sessionManager->getStorage($userManager);
        if($storage->has('user')) {
            $auth = new Authentication($this->getServiceLocator());
            $user = $storage->get('user');

            if($auth->authenticate($user->getUsername(), $user->getPassword())) {
                $userManager->setUser($storage->get('user'));
            } else {
                $storage->reset('user');
            }
        }
    }
}

?>