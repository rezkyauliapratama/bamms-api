<?php

// DIC configuration
$container = $app->getContainer();

//eloquent
  $capsule = new \Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($container['settings']['db']);

// $capsule->setEventDispatcher(new Illuminate\Events\Dispatcher(new Illuminate\Container\Container));
  $capsule->setAsGlobal();
  $capsule->bootEloquent();



$container['db'] = function ($container) use ($capsule){
    return $capsule;
};


 $container->get('db')->getContainer()->singleton(
  Illuminate\Contracts\Debug\ExceptionHandler::class,
  App\Exceptions\Handler::class
);


// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//controller
// Add our invokable class to the container
// Choose a name for it in the container

$container['UserController'] = function($container) {
// note the use of the namespace
// $container is injected to pass it to the class
    return new app\controllers\UserController();

};

$container['UserRoleController'] = function($container) {
// note the use of the namespace
// $container is injected to pass it to the class
    return new app\controllers\UserRoleController();

};

$container['LoginController'] = function($container) {
// note the use of the namespace
// $container is injected to pass it to the class
    return new app\controllers\LoginController();

};

$container['ActivityController'] = function($container) {
// note the use of the namespace
// $container is injected to pass it to the class
    return new app\controllers\ActivityController();

};

$container['ActivityDetailController'] = function($container) {
// note the use of the namespace
// $container is injected to pass it to the class
    return new app\controllers\ActivityDetailController();

};
