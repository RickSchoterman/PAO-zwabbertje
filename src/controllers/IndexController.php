<?php

namespace Main\src\Controller;

use Database\Services\EntityManager;
use Library\ControllerModel;
use Mvc\ViewModel;

class IndexController extends ControllerModel {
    public function indexAction() {
        $router = $this->getServiceLocator()->get('Router\Services\Router');
        $userManager = $this->getServiceLocator()->get('User\Services\UserManager');

        if(!$userManager->hasUser()) {
            $router->redirect('account');
        }

        return array(

        );
    }

    public function employeeAction() {
        /* @var $entityManager EntityManager */
        $entityManager = $this->getServiceLocator()->get('Database\Services\EntityManager');

        if(isset($_POST['ajax_call'])){
            switch ($_POST['ajax_call']){
                case 'edit':
                    $entityManager->getRepository('Employee')->save($employees);
                    break;
                case 'create':
                    $entityManager->getRepository('Employee')->save($employees);
                    break;
                case 'delete':
                    $employee = $entityManager->getRepository('Employee')->findBy(array('id' => $_GET['id']));
                    $entityManager->getRepository('Employee')->delete($employee);
                    break;
            }
        } else {
            $employees = $entityManager->getRepository('Employee')->findOneBy(array());

            return array(
                'employees' => $employees
            );
        }
    }

    public function scheduleAction() {
        return array(
            
        );
    }

    public function notFoundAction() {
        return array(

        );
    }
}

?>
