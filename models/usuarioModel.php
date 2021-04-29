<?php

class UsuarioModel {
    public function __construct() {
        $this->db = $this->createConection();
    }

    Private function createConection(){
        $host = 'localhost';
        $userName = 'root';
        $password = '';
        $database = 'db_final';
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $userName , $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public function nuevaOpcion($idEncuesta, $texto){
        $sentencia = $this->db->prepare("INSERT INTO opcion VALUE (?,?)");
        $sentencia->execute([$idEncuesta, $texto]);
    }

    //LA TABLA SERÍA ASÍ
    USUARIO(id: int; user: string, passrow: string);
}