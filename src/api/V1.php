<?php
$app->group("/v1", function() use($app) {

    //user
    $app->get('/users', 'UserController:users');
    $app->get('/user', 'UserController:userbyid');
    $app->post('/user', 'UserController:create');

    //account
    $app->get('/accounts', 'AccountController:getAccounts');
    $app->post('/accountByNumber', 'AccountController:getByAccountNumber');
    $app->post('/accountsManager', 'AccountController:getListForManager');

     //transaction
     $app->get('/transactions', 'TransactionController:getAllTransactions');
     $app->post('/transactionsByDate', 'TransactionController:getAllTransactionsByDate');
     $app->post('/cardTransactionsByDate', 'TransactionController:getAccountTransactionsByDate');
     $app->post('/transaction', 'TransactionController:create');
     $app->post('/transfer', 'TransactionController:transferToAnotherAccount');





    //userrole
    $app->get('/userroles', 'UserRoleController:UserRoles');

    //login
    $app->post('/login', 'LoginController:signin');

  });
