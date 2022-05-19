<?php

declare(strict_types=1);

use App\Controller\User;
use App\Middleware\Auth;
use App\Controller\Producto;

/** @var \Slim\App $app */

$app->get('/', 'App\Controller\DefaultController:getHelp');
$app->get('/status', 'App\Controller\DefaultController:getStatus');
$app->post('/login', \App\Controller\User\Login::class);

$app->group('/users', function () use ($app): void {
    $app->get('', User\GetAll::class)->add(new Auth());
    $app->post('', User\Create::class);
    $app->get('/{id}', User\GetOne::class)->add(new Auth());
    $app->put('/{id}', User\Update::class)->add(new Auth());
    $app->delete('/{id}', User\Delete::class)->add(new Auth());
});

$app->group('/producto', function () use ($app): void {
    $app->get('', Producto\GetAll::class);
    $app->post('', Producto\Create::class);
    $app->get('/{id}', Producto\GetOne::class);
    $app->put('/{id}', Producto\Update::class);
    $app->delete('/{id}', Producto\Delete::class);
})->add(new Auth());
