<?php 

namespace src\cron;

require(__DIR__.'/../../vendor/autoload.php');

use src\models\User;

$user = new User();
$user->updateRates();