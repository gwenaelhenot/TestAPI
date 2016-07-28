<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["Settings" => $config]);

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/contracts', function(Request $request, Response $response){
    $contracts = json_decode(file_get_contents('https://api.jcdecaux.com/vls/v1/contracts?apiKey=18bfc889900775865ce3f77eb407292644f062f1'));
    return $response->withJson($contracts);
});

$app->get('/stations/{city}', function(Request $request, Response $response){
    $city = $request->getAttribute('city');
    $stations = json_decode(file_get_contents('https://api.jcdecaux.com/vls/v1/stations?contract='.$city.'&apiKey=18bfc889900775865ce3f77eb407292644f062f1'));
    return $response->withJson($stations);
});

$app->run();