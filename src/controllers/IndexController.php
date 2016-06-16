<?php

namespace Main\src\Controller;

use Database\Entity;
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
//                    $data = parse_str($_POST['data']);
//
//                    $entityManager->getRepository('Employee')->findBy(array('id' => $id));
//                    $entityManager->save($employees);
                    break;
                case 'create':
                    parse_str($_POST['data'], $data);

                    $newEmployee = new Entity('employee', $data);
                    
                    $entityManager->save($newEmployee);

                    exit;
                    break;
                case 'delete':
//                    $employee = $entityManager->getRepository('Employee')->findBy(array('id' => $_GET['id']));
//                    $entityManager->delete($employee);
                    break;
            }
        } else {
            $employees = $entityManager->getRepository('Employee')->findBy(array());

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
