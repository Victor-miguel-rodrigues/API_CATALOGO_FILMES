<?php

use Api\Filmes\Controller\FilmeController;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;


try{
     SimpleRouter::setDefaultNamespace('Api\Filmes\Controller');

     SimpleRouter::get('api/', [FilmeController::class, 'index']);

     SimpleRouter::start();
}catch(NotFoundHttpException $e){
     echo $e->getMessage();
}