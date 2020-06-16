<?php

$routes->get('/', 'HomeController@index');

$routes->group('user', 'user', function () use ($routes){
    $routes->get('/create', 'UserController@create');
    $routes->post('/', 'UserController@store');
});

$routes->group('auth', 'auth', function () use ($routes){
    $routes->get('/login', 'AuthController@login');
    $routes->post('/login', 'AuthController@signin');
    $routes->get('/logout', 'AuthController@logout');
});

$routes->group('todo', 'todo_list', function () use ($routes){
    $routes->post('/', 'TodoController@save');
    $routes->get('/{todo_id}', 'TodoController@show');
    $routes->delete('/{todo_id}', 'TodoController@destroy');
});

$routes->group('todo_list','todo_list', function () use ($routes){
    $routes->post('/', 'TodoListController@store');
    $routes->delete('/{list_id}', 'TodoListController@destroy');
});

$routes->get('/dashboard', 'DashboardController@index');

$routes->dispatch();