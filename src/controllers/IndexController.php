<?php

class IndexController {

    protected $serviceLocator;

    public function __construct(Locator $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function indexAction() {
        $database = $this->getServiceLocator()->get('Database');

        $user = $database->getUser(array(
            'user_id' => '1'
        ));

        $messageService = $this->getServiceLocator()->get('MessageService');

        return new ViewModel(array(
            'userMessage' => $messageService->getUserMessage($user),
        ));
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