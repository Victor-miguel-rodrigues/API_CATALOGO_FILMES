<?php
namespace Api\Filmes\utils;

use Api\Filmes\API\ConsumoApi;

class Descetralizador {

        
        public ConsumoApi $api;

        public  function limpar($nome,$t){
                $this->api = new ConsumoApi();
                $buscado = $this->api->buscarNaApi($nome,$t);

                $dadosSelecionados = [  
                              'titulo' =>  $buscado['Title'], 
                              'ano' =>  $buscado['Year'],  
                             'idioma' =>   $buscado['Language'],
                             'data_completa'  =>  $buscado['Released'],
                             'duracao' =>   $buscado['Runtime'],
                              'genero' =>  $buscado['Genre'],
                             'image' =>   $buscado['Poster'],
                              'avaliacao' =>  $buscado['imdbRating'],
                             'tipo' =>   $buscado['Type']
                ];
        
                return $dadosSelecionados;
        }


}