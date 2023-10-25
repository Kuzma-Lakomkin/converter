<?php 

namespace src\controllers;

use src\core\Controller;
use Valitron\Validator;


class AccountController extends Controller
{
    public function loginAction()
    {
        if (!empty($_POST)) {
            $result = $this->model->entryToApplication($_POST);
            if (!$result) {
                // Если аутентификация не удалась, возвращаем ошибку с соответствующим кодом состояния HTTP
                http_response_code(401); // Устанавливаем код состояния 401 (Unauthorized)
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Login or password entered incorrectly']);
                exit;
            } else {
                // Если аутентификация успешна, выполняем редирект
                exit;
            } 
        } else { 
            // В любом случае отображаем HTML-форму
            $this->view->render("Авторизация");
        }
    }


    public function registerAction()
    {
        if (!empty($_POST)) { 
            $validator = new Validator($_POST);
            $validator->rules(require '../src/config/rules.php');
            if ($validator->validate()) {
                if ($this->model->checkLoginExists($_POST['login'])) {
                    $this->model->addUserToBase($_POST);
                    echo json_encode(['success' => 'success']);
                    exit;
                } else {
                    echo json_encode(['error' => [['Login is already in use. Please change it.']]]);
                }
            } else {
                    header('Content-Type: application/json');
                    echo json_encode(['error' => $validator->errors()]);
                }
        exit;
        }
        $this->view->render("Регистрация");
    }
}
