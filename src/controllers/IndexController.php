<?php

class IndexController {

    protected $serviceLocator;

    public function __construct(Locator $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function indexAction() {
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