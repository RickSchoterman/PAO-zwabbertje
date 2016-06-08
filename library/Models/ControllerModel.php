<?php

namespace Library;

use Main\Locator;

class ControllerModel {

    protected $serviceLocator;

    public function __construct(Locator $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function notFoundAction() {
        return array();
    }

    public function getDatabase() {
        return $this->getServiceLocator()->get('Database\Services\Database');
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