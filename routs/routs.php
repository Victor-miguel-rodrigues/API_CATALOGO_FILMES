<?php

use Api\Filmes\Controller\FilmeController;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

const regexx =  "[A-Za-z0-9\s+\-' ]+";

try{
     SimpleRouter::setDefaultNamespace('Api\Filmes\Controller');

     SimpleRouter::group(['prefix' => 'api/'], function(){

         SimpleRouter::get('/', [FilmeController::class, 'index']);

         SimpleRouter::get("/bus/{nome}", [FilmeController::class, 'buscarFilme'])->where(['nome' => regexx]);
        
         

         // direto da api
         SimpleRouter::get('/filmes/{type}/{cat}', [FilmeController::class, 'BuscarGrande'])->where([
            'type' => '[A-Za-z]+',
            'cat'  => regexx
         ]);

         // Buscando filmes categorias salvas no banco de dados
          SimpleRouter::get('/categoria/{cat}', [FilmeController::class, 'categorias'])->where([
                'cat'  => regexx
         ]);



         // Buscando filmes por genero

         SimpleRouter::get('/genero/{gen}', [FilmeController::class, 'generos'])->where([
                'gen'  => regexx
         ]);


         SimpleRouter::get("/categoria/{cat}/genero/{gen}", [FilmeController::class, "getCatGenre"])->where([
               'cat' => regexx,
               "gen" => regexx
         ]);

         SimpleRouter::get('/serie/{nome}', [FilmeController::class, "buscarSerie"])->where([
           'nome' => regexx
         ]);
     });

     SimpleRouter::start();
}catch(NotFoundHttpException $e){
     echo $e->getMessage();
}