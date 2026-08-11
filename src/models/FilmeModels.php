<?php

namespace    Api\Filmes\models;

use Api\Filmes\configure\Configuration;
use Exception;
use PDO;

class FilmeModels{

        public  Configuration $configDB;

        public function __construct()
        {
             $this->configDB = new Configuration();
        }

        public function send(array $dados)
        {   
               //return $dados;
               $db = $this->configDB->getInstancia();

              foreach($dados as $dado => $istrue){
                    if(empty($istrue)){
                         return throw new Exception("ERRO {$dado} is -empty");
                    }
              }

             /* $dados['avaliacao'] = ($dados['avaliacao'] == 'N/A') ? 0 : $dados['avaliacao'];
              return $dados;*/
             // return "ola";

             //return $dados;
              //print_r($this->verify($dados['titulo']));
                if($this->verify($dados['titulo'])){
                      return $dados; 
                }else{
                       $dados['avaliacao'] = ($dados['avaliacao'] == 'N/A') ? 0 : $dados['avaliacao'];
                       $stmt = $db->prepare("INSERT INTO filmes (titulo, ano,idioma,data_completa,duracao,genero,image,avaliacao,tipo) values (?,?,?,?,?,?,?,?,?)");
                         $stmt->execute([
                                   $dados['titulo'],
                                   $dados['ano'],
                                   $dados['idioma'],
                                   $dados['data_completa'],
                                   $dados['duracao'],
                                   $dados['genero'],
                                   $dados['image'],
                                   $dados['avaliacao'],
                                   $dados['tipo']
                         ]);
                        
                         if($stmt->rowCount() > 0){
                              return $dados;
                         }
                }
        }

        public function verify($nome){
            
               $sql = "SELECT EXISTS(SELECT titulo FROM  filmes where  titulo = ?) as existe";
               $db = $this->configDB->getInstancia();
               $stmt =  $db->prepare($sql);
               $stmt->execute([$nome]);
                              
               $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
               return (bool) $resultado['existe'];
               
        }


        public function buscarCategoria($categoria){
             $sql = "SELECT * FROM filmes where tipo = ?";
             $db = $this->configDB->getInstancia();
             $stmt = $db->prepare($sql);

             $stmt->execute([$categoria]);

             if($stmt->rowCount() > 0){
                  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  return $resultado;
             }else{
                 return http_response_code(400);
             }
        }



        public function genero(){
               $db = $this->configDB->getInstancia();

               $sql = "Select * from filmes";
               $stmt = $db->prepare($sql);
               $stmt->execute();

               if($stmt->rowCount() > 0){
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
               }
        }
}