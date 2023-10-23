<?php 

namespace src\models;

use src\core\Model;
use Valitron\Validator;


class Account extends Model
{

    public array $rules = [
        'required' => ['first_name', 'last_name', 'login', 'password',],
        'lengthBetween' => [
            ['first_name', 1, 50],
            ['last_name', 1, 50],
            ['login', 1, 50],
            ['password', 8, 50],
        ],
        'slug' => ['login'],
    ];

    public function validateRegistration($data) // вынести в отдельный файл
    {
        $validator = new Validator($data);
        $validator->rules($this->rules);
        if ($validator->validate()) {
                if ($this->checkLoginExists($data['login'])) {
                    return true;
                }
                /*$this->db->query('INSERT INTO users (first_name, last_name, login_user, password_user)
                                VALUE (:first_name, :last_name, :login, :password)', $data); в этом коде должен хэшироваться пароль^ добавить лучше в виде парамс*/ 
                $this->errors = [
                    'error' => [
                        'Login is already in use. Please change it.'
                    ],
                ];
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }


    public function getErrors()
    {
        return $this->errors;
    }


    public function checkLoginExists($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($this->db->column('SELECT id FROM users WHERE login_user = :login', $params)) {
            return false;
        } else {
            return true;
        }
    }
    
    
    public function entryToApplication()
    {
        $params = [
            'login' => $_POST['login'],
            'password' => $_POST['password'],
        ];

        if ($this->db->column('SELECT id FROM users WHERE login_user = :login and password_user = :password', $params)) {
            $_SESSION['authorize'] = $_POST['login'];
            return true;
        } else {
            return false;
        }
    }

}   