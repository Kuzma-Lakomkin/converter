<?php 

namespace src\controllers;

use src\core\Controller;


class AccountController extends Controller
{
    public function loginAction()
    {
        if (!empty($_POST)) {
            $result = $this->model->entryToApplication($_POST);
            if (!$result) {
                // Если аутентификация не удалась, возвращаем JSON с ошибкой
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Login or password entered incorrectly']);
            } else {
                // Если аутентификация успешна, возвращаем JSON с сообщением об успешной аутентификации
                header('Content-Type: application/json');
                echo json_encode(['success' => 'Login successful']);
            }
        } else {
            // В любом случае отображаем HTML-форму
            $this->view->render("Авторизация");
        }        
    }


    public function registerAction()
    {
        if (!empty($_POST)) { 
            $response = $this->model->validateRegistration($_POST);
                if ($response === true) {
                    echo json_encode(['success' => 'success']);
                    exit;
                } else {
                    echo json_encode(['error' => $this->model->getErrors()]);
                }
        exit;
        }
        $this->view->render("Регистрация");
    }
}
