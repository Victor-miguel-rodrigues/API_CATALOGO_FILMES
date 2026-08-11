<?php
 
header('Content-Type: application/json; charset=utf-8');

require "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require 'routs/routs.php';
