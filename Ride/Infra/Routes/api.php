<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/ride/{accountId}', "RideController@getById");
