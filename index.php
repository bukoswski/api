<?php

header('Acess-Control-Allow-Origin: *');
//header('');
header('Content-Type: application/json');
date_default_timezone_set("America/Sao_Paulo");

//var_dump($_GET['path']);

//$path = isset($_GET[$path]) ? explode("/", $_GET[$path[0]]) : die("caminho não achado");
$path = isset($_GET['path']) ? explode("/", $_GET['path']) : die("Caminho não achado");

$api = isset($path[0]) ? $path[0] : die("caminho não encontrado"); //O operador ternário ?: verifica se $path[0] está definido.
//$api = $path[0] ?? die("Caminho não existe"); //O operador ?? verifica se $path[0] está definido e não é null.

//$acao = $path[1] ?? die("Ação não existe");
//$acao = isset($path[1]) ? $path[1] : exit("nao");
//$param = $path[2] ?? exit();

if (isset($path[1])) {
    $acao = $path[1];
} else {
    echo "";
}

if (isset($path[2])) {
    $param = $path[2];
} else {
    echo "";
}

//$method = $_SERVER['REQUEST_METHOD']; //Pega o método da requisição.
$method = $_SERVER['REQUEST_METHOD'];
//var_dump($method);

include_once "config/Database.php";
include_once "api/Clientes/clientes.php";
