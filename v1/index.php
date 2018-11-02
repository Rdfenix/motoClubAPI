<?php

    session_start();
    require_once("vendor/autoload.php");

    use \Slim\Slim;
    use \Slim\Slim\Http\Request;
    use \Slim\Slim\Http\Response;
    use \ApiMotoClub\Model\User;
    use \ApiMotoClub\Model\Group;

    $app = new Slim();

    $app->get('/welcome', function(){
        echo "Bem vindo a API de acesso para o projeto moto club";
    });

    $app->post('/usuario/register', function(){
        $user = new User();
        $request = Slim::getInstance()->request();
        $response =  $request->getBody();
        $result = json_decode($response);
        $user->setData($result);
        $data = $user->registerUser();
        echo json_encode($data);
    });

    $app->post('/usuario/login', function(){
        $user = new User();
        $request = Slim::getInstance()->request();
        $response = $request->getBody();
        $result = json_decode($response);
        $data = $user->login($result->email_user, $result->pass_user);
        echo json_encode($data);
    });

    $app->get('/usuario/:email', function($email){
        $user = new User();
        $result = $user->listUser($email);
        echo $result;
    });

    $app->post("/grupo/register", function(){
        $group = new Group();
        $request = Slim::getInstance()->request();
        $response = $request->getBody();
        $result = json_decode($response);
        $group->setData($result);
        $data = $group->registerGroup();
        echo json_encode($data);
    });


    $app->run();
