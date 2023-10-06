<?php 

namespace src\models;

use src\core\Model;
use Valitron\Validator;


class Account extends Model
{

    public array $rules = [
        'required' => ['first_name', 'last_name', 'login', 'password',],
        'lengthBetween' => [
            ['first_name', 1, 255],
            ['last_name', 1, 255],
            ['login', 1, 255],
            ['password', 8, 255],
        ],
        'slug' => ['login'],
    ];

    public function validateRegistration($data)
    {
        $validator = new Validator($data);
        $validator->rules($this->rules);
        if ($validator->validate()) {
                $this->db->query('INSERT INTO users (first_name, last_name, login_user, password_user)
                                VALUE (:first_name, :last_name, :login, :password)', $data);
        return true;
        } else {
            $this->errors = $validator->errors();
            print_r($this->errors);
        }
    }

    public function loginExists()
    {
        
    }
}