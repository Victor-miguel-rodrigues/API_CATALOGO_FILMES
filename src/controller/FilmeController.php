<?php
namespace Api\Filmes\Controller;


use Api\Filmes\utils\Descetralizador;

class FilmeController{

        public Descetralizador $desc;

        public function index(){
                $this->get();
        }
        public function get(){
                $this->desc = new Descetralizador();
                $limpo = $this->desc->limpar('matrix','t');
                
                 print_r($limpo);
        }
}