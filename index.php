<?php

header("Content-Type: application/json");

ini_set("display_errors", 1);

require  __DIR__ . "/vendor/autoload.php";

use Api\App;
use Services\User;

$app = new App();

$app->route("/users/{id}", ['GET', 'POST', 'PUT'], User::class, 'getUser');

$app->route("/index/index/{id}/{d}", ['GET'], User::class, 'getUser');

$app->run();



