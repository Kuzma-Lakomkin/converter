<?php 

namespace src\cron;

use src\models\User;

$user = new User();
$user->updateRates();