<?php 

namespace src\controllers;

use src\core\Controller;


class UserController extends Controller
{
    public $vars;


    public function rateAction()
    {   
        if (empty($this->model->getRates())) {
            $params = $this->parser->sendRatesToDatabase();
            $listRates = $this->model->addRates($params);
        } else {
            $listRates = $this->model->getRates();
        }
        $this->vars = [
            'rates' => $listRates,
        ];
        $this->view->render("Страница со спаршенными валютами", $this->vars);
    }



    public function converterAction()
    {
        $this->vars = [
            'valutes'=> $this->model->addRubles(),
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['from_currency'])) {
            // Если это POST-запрос, обрабатываем AJAX-запрос и возвращаем JSON
            $this->model->converter();
        } else {
            // Если это GET-запрос, отображаем HTML-страницу
            $this->view->render("Конвертер валют", $this->vars);
        }
    }
    

    public function logoutAction()
    {
        unset($_SESSION['authorize']);
        $this->view->redirect('/converter/account/login');
    }
}
