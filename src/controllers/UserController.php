<?php 

namespace src\controllers;

use src\core\Controller;


class UserController extends Controller
{
    public function rateAction()
    {  
        $listRates = $this->model->getRates();
        $vars = [
            'rates' => $listRates,
        ];
        $this->view->render("Страница со спаршенными валютами", $vars);
    }

    public function converterAction()
    {
        $this->model->converter();
        $this->view->render("Конвертер валют");
    }

    public function logoutAction()
    {
        //unset($_SESSION['user']);
        $this->view->redirect('converter/account/login');
    }
}