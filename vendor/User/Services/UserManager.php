<?php

namespace User\Services;

use Library\EmployModel;

class UserManager {

    protected $user;

    protected $entityManager;
    protected $sessionManager;

    public function __construct() {

    }

    public function inject(EmployModel $employ) {
        $serviceLocator = $employ->getServiceLocator();

        $sessionManager = $serviceLocator->get('Session\Services\SessionManager');
        
        $this->setSessionManager($sessionManager);
    }

    public function login($user) {
        $storage = $this->getSessionManager()->getStorage($this);
        $storage->set('user', $user);
        $this->setUser($user);
    }

    public function logout() {
        $storage = $this->getSessionManager()->getStorage($this);
        $storage->reset('user');
        $this->clear();
    }

    public function hasUser() {
        if($this->user) {
            return true;
        }

        return false;
    }

    private function clear() {
        $this->user = null;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    /**
     * @param mixed $sessionManager
     */
    public function setSessionManager($sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }


}

?>