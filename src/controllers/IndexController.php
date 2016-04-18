<?php

class IndexController {

    protected $serviceLocator;

    public function __construct(Locator $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function indexAction() {
        $database = $this->getServiceLocator()->get('Database');

        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $user = $database->getUser(array(
            'email' => $email,
            'pass' => $pass
        ));

        if($user && count($user) == 1) {
            //login
        } else if(!$user) {
            //verkeerd username/pass
        } else if(count($user) > 1) {
            //fout databse
        }

        return array();
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