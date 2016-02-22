<?php

class Reservation {

    protected $serviceLocator;

    public function __construct(Locator $serviceLocator) {
        $this->getServiceLocator($serviceLocator);
    }

    public function read() {
        return array();
    }

    public function create() {
        return array(
            'action' => 'create',
        );
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