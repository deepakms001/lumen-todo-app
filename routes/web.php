<?php

$router->get('/', function () use ($router) {
    return response()->json(['api' => 'Todo App API', 'version' => "1.0.0"]);
});


$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/signup', 'AuthController@signup');
    $router->post('/signin', 'AuthController@signin');
});

$router->group(['middleware' => ['jwt.auth']], function () use ($router) {

    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->post('/', 'CategoryController@create');
        $router->get('/', 'CategoryController@list');
        $router->get('/{categoryId}', 'CategoryController@get');
        $router->put('/{categoryId}', 'CategoryController@update');
        $router->delete('/{categoryId}', 'CategoryController@delete');
    });

    $router->group(['prefix' => 'task'], function () use ($router) {
        $router->post('/', 'TaskController@create');
        $router->get('/', 'TaskController@list');
        $router->get('/{categoryId}', 'TaskController@get');
        $router->put('/{categoryId}', 'TaskController@update');
        $router->delete('/{categoryId}', 'TaskController@delete');
    });
});
