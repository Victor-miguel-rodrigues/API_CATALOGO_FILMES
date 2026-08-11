<?php
namespace Api\Filmes\Controller;


use Api\Filmes\models\FilmeModels;
use Api\Filmes\utils\Descetralizador;
use  Api\Filmes\service\FilmesService;
use Exception;

class FilmeController{

        public Descetralizador $desc;
        public  FilmesService $service;
        public FilmeModels $models;


        public function index(){
                $this->get('');
        }

        public function buscarFilme($name) {
                $this->get($name);
        }
        
        public function categorias($categoria){
                $this->service = new FilmesService();
                print_r($this->service->categoria($categoria));

           
        }

        public function BuscarGrande($type,$categoria){
                $this->service = new FilmesService();
                $srs = $this->service->categoriaApi($type, $categoria);
                print_r($srs);
                
        }

        public function get($nomeFilme){
                try{
                        
                        $this->desc = new Descetralizador();
                        $limpo = $this->desc->buscarFilme($nomeFilme, 't');
                        
           
                        $this->models = new FilmeModels();
                        print_r( $this->models->send($limpo));
                }catch(Exception $e){
                         echo $e->getMessage();
                }
        }

        public function generos($genero){
             $this->service = new FilmesService();
              print_r($this->service->genero($genero));
        }


        public function getCatGenre($categoria, $genero){
                  $this->service = new FilmesService();
                  print_r($this->service->BuscarcategoriaeGenero($categoria,$genero));
        }

}