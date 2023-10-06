<?php 

namespace src\controllers;

use src\core\Controller;

class AccountController extends Controller
{
    public function loginAction()
    {
        $this->view->render("Авторизация");
    }

    public function registerAction()
    {
        $nonEmptyValues = array_filter($_POST, function ($value) {
            return $value !== null && $value !== "";
        }); 
        if (!empty($nonEmptyValues)) {
            if (!$this->model->validateRegistration($_POST)) {
                foreach ($this->model->errors as $errorArray) {
                    foreach ($errorArray as $error) {
                        $this->view->message('error', $error);
                    }    
                }
            } else {
                echo 'YES';
            }
        } else {
            $this->view->message('error', 'empty values');
        }
        $this->view->render("Регистрация");
    }
}