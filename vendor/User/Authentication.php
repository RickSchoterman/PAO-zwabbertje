<?php

namespace User;

use Main\Locator;

class Authentication {

    protected $serviceLocator;
    protected $sessionManager;

    protected $entityManager = 'Database\Services\EntityManager';

    public function __construct(Locator $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function authenticate($usernameOrEmail, $password) {
        $type = $this->getType($usernameOrEmail);

        $database = $this->getServiceLocator()->get($this->entityManager);
        $user = $database->getUser(array(
            $type => $usernameOrEmail,
            'password' => $password
        ));

        if(count($user) == 1) {
            return $user;
        }

        return false;
    }

    public function getType($usernameOrEmail) {
        if(filter_var($usernameOrEmail ,FILTER_VALIDATE_EMAIL) !== false) {
            return 'email';
        }

        return 'username';
    }

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param mixed $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}

?>