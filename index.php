<?php

header('Content-Type: application/json; charset=utf-8');

require "vendor/autoload.php";

require 'routs/routs.php';

/*
use Api\Filmes\Controller\FilmeController;

$controller = new FilmeController();
$controller->get();
*/

/*
$nomeFilme = "O+Poderoso+chefao";
$api = "http://www.omdbapi.com/?t={$nomeFilme}&apikey=6e44878a";

$filmeRetornado = json_encode(file_get_contents($api));
echo $filmeRetornado;
*/