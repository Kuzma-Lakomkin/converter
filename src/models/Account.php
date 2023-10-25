<?php 

namespace src\models;

use src\core\Model;


class Account extends Model
{


    public function addUserToBase()
    {
        $params = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'login' => $_POST['login'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),

        ];

        $this->db->query('INSERT INTO users (first_name, last_name, login_user, password_user)
                    VALUE (:first_name, :last_name, :login, :password)', $params); 
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
        ];

        $hashedPassword = $this->db->column('SELECT password_user FROM users WHERE login_user = :login', $params);

        if (password_verify($_POST['password'], $hashedPassword)) {
            $_SESSION['authorize'] = $params['login'];
            return true;
        } else {
            return false;
        }
    }
}   
