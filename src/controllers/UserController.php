<?php 

namespace src\controllers;

use src\core\Controller;
use src\app\Converter;


class UserController extends Controller
{
    public array $vars;
    public array $listRates;
    public Converter $converter;


    public function rateAction()
    {   
        $listRates = $this->model->checkDatabase();
        $this->vars = [
            'rates' => $listRates,
        ];
        $this->view->render("Страница со спаршенными валютами", $this->vars);
    }


    public function converterAction()
    {
        $userRates = $this->model->checkDatabase();
        $this->converter = new Converter($userRates);
        $this->vars = [
            'valutes'=> $this->converter->addRubles(),
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['from_currency'])) {
            // Если это POST-запрос, обрабатываем AJAX-запрос и возвращаем JSON
            $this->converter->converterCurrency();
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
