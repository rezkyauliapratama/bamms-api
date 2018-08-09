<?php
$app->group("/v1", function() use($app) {

    //user
    $app->get('/users', 'UserController:users');
    $app->get('/user', 'UserController:userbyid');
    $app->post('/user', 'UserController:create');



    //userrole
    $app->get('/userroles', 'UserRoleController:UserRoles');

    //login
    $app->post('/login', 'LoginController:signin');

  });
