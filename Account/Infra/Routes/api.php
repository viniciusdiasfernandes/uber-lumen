<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/account/{accountId}', "AccountController@getByid");
$router->post('/signup', "AccountController@signup");
$router->put('/account/{accountId}', "AccountController@update");
