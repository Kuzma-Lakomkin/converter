<?php 

return [
        'required' => ['first_name', 'last_name', 'login', 'password',],
        'lengthBetween' => [
            ['first_name', 1, 50],
            ['last_name', 1, 50],
            ['login', 1, 50],
            ['password', 8, 50],
        ],
        'slug' => ['login'],
    ];