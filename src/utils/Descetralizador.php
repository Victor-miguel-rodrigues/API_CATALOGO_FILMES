<?php
namespace Api\Filmes\utils;

use Api\Filmes\API\ConsumoApi;
use Exception;
use FilmesService;

class Descetralizador  {

        
        public ConsumoApi $api;

        public  function limpar(array $buscado){
                //array(array(13131),array(122212))
                foreach($buscado as $busca){
                         return $busca;
                }               
        }


        public function buscarFilme($nome,$Type){
                $this->api  = new ConsumoApi();
                $nome = $this->Modify($nome);
                $buscado = $this->api->buscarNaApi($nome,$Type);
                

                $dadosSelecionados = [  
                              'titulo' =>  $buscado['Title'] ?? "", 
                              'ano' =>  $buscado['Year'] ?? "",  
                             'idioma' =>   $buscado['Language'] ?? "",
                             'data_completa'  =>  $buscado['Released'] ?? "",
                             'duracao' =>   $buscado['Runtime'] ?? "",
                              'genero' =>  $buscado['Genre'] ?? "",
                             'image' =>   $buscado['Poster'] ?? "",
                              'avaliacao' =>  $buscado['imdbRating'] ?? "",
                             'tipo' =>   $buscado['Type'] ?? ""
                ];
        
             return $dadosSelecionados;
        }

        public function Modify($nome){
                $nome = str_replace(" ", "+", $nome);
                return $nome;
        }

        public function __clone(){}

}