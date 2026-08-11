<?php

namespace Api\Filmes\API;
use Exception;

class ConsumoApi{

        public function buscarNaApi(String $name, string $type){
            try{
                $api = "http://www.omdbapi.com/?{$type}={$name}&apikey=6e44878a";
                $buscaRetornada = json_decode(file_get_contents($api), true);
                return $buscaRetornada;
            }catch(Exception $e){
                    echo $e->getMessage();
            }
        }

        
}