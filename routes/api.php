<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group(['namespace' => 'App\Http\Controllers'], function (Router $api) {
        $api->get('/report', 'QuoteController@download');
        $api->post('/login', 'Auth\\LoginController@login');
        $api->get('/logout', 'Auth\\LoginController@logout');
        $api->post('/register', 'Auth\\RegisterController@register');
        $api->group(['middleware' => ['auth:api']], function (Router $api) {
            $api->resource('/church', 'ChurchController');
            $api->resource('/song', 'SongController');
            $api->resource('/event', 'EventController');
            $api->resource('/quote', 'QuoteController');
            $api->resource('/project', 'ProjectController');
            $api->resource('/party', 'PartyController');
        });
    });
});
