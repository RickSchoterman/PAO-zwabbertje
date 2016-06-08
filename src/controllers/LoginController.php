<?php

class LoginController {

    protected $serviceLocator;

    public function __construct(Locator $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function indexAction() {
        if ($_POST){
            $username = $_POST['user'];
            $password = $_POST['pass'];
            
            $database = $this->getServiceLocator()->get('Database');
            
            $user = $database->getUser(array(
                'user' => $username,
                'pass' => $password,
            ));
            
            if($user) {
                //matched
            } else {
                //no matches
            }
        }

        return array(
            
        );
    }

    public function notFoundAction() {
        return array();
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