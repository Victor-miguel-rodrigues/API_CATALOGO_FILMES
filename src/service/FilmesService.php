<?php
namespace Api\Filmes\service;


use Api\Filmes\API\ConsumoApi;
use Api\Filmes\models\FilmeModels;
use Api\Filmes\utils\Descetralizador;

class FilmesService  extends Descetralizador{

        public ConsumoApi $api;
        public Descetralizador $descentralizer;
        public FilmeModels $filme;
        
        public function __construct(){
                  $this->api = new ConsumoApi();
                  $this->descentralizer = new Descetralizador();
                  $this->filme = new FilmeModels();
        }


        public function categoria($categoria){
                return  $this->filme->buscarCategoria($categoria);
        }

        
        public function categoriaApi($type,$nome){
                $nome = $this->Modify($nome);
                $srs = $this->api->buscarNaApi($nome,$type);
                
                $as = $this->descentralizer->limpar($srs);

                print_r($as);
                //$this->send_data($as);
                //return   $this->send_data($as);
        }


        public function send_data(array $dados){
                for($i = 0; $i <= count($dados,COUNT_NORMAL); $i++){
                              
                }
        }
        
        /**
         * 
         *  @annotation
         * generos  pega todos os dados do banco de dados 
         *  @code $filme -> para armazenar todos os generos depois de buscado
         * @var  $genero = strtolower para colocar as letras em minusculas
         * @author vitin <>
         */
        public function genero($genero){
                $generos = $this->filme->genero();
                $filme = [];
                $genero = strtolower($genero);

                foreach($generos as $genre){
                        $generoatauis = array_map( 'trim', explode(",", strtolower($genre['genero'])));

                        if(in_array($genero ,$generoatauis)){
                                $filme[] = $genre;
                        }
                }
                
                print_r($filme);
        }


        public function BuscarcategoriaeGenero($categoria, $genero){
                $generos = $this->filme->buscarCategoria($categoria);

                foreach($generos as $genre){
                        $generoatauis = array_map( 'trim', explode(",", strtolower($genre['genero'])));

                        if(in_array($genero ,$generoatauis)){
                                $filme[] = $genre;
                        }
                }
                
                print_r($filme);
        }
                
}









                /*for($i = 0; $i < count($generos); $i++){
                        $generos[$i] = explode(",",$generos[$i]['genero']);        

                        if(in_array($genero,$generos)){
                                $filme[] = $generos;
                        }
                }*/












/* [Title] => The Big Bang Theory
     [Year] => 2007–2019
     [imdbID] => tt0898266
     [Type] => series
     [Poster] => https://m.media-amazon.com/images/M/MV5BZjgzY2QyNzItNDhhYi00ZWIwLWFjN2UtZDJkN2MxYWNjMmJjXkEyXkFqcGc@._V1_SX300.jpg
         }*/
        /**
         * type = s
         *   Title] => The Big Bang Theory
                [Year] => 2007–2019
                [imdbID] => tt0898266
                [Type] => series
                [Poster] => https://m.media-amazon.com/images/M/MV5BZjgzY2QyNzItNDhhYi00ZWIwLWFjN2UtZDJkN2MxYWNjMmJjXkEyXkFqcGc@._V1_SX300.jpg
         * 
         * type = t
         *                 $dadosSelecionados = [  
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
       */