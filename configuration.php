<?php

namespace Api\Filmes\configure;

use PDO;
use PDOException;

class Configuration{

        private static  $instancia;

        public function getInstancia() : PDO { 
                try
                {
                      $opt =  [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_PERSISTENT => PDO::FETCH_OBJ,
                                PDO::CASE_NATURAL => PDO::ATTR_CASE
                            ];
                        self::$instancia = new PDO( "mysql:host={$_ENV['DB_HOST']}; dbname={$_ENV['DB_NAME']}; charset=utf8mb4", $_ENV['DB_USER'], $_ENV['DB_PASS'], $opt );

                        return self::$instancia;
                }catch(PDOException $e){
                        echo $e->getMessage();
                }
                return self::$instancia;
        }
}