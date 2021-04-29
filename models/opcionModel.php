<?php

class OpcionModel {
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
    
    public function getOpcionesDeEncuesta($id){
        $sentencia = $this->db->prepare("SELECT * FROM opcion WHERE id_encuesta=?");
        $sentencia->execute([$id]);
        $opcion = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $opcion;
    }

    public function nuevaOpcion($idEncuesta, $texto){
        $sentencia = $this->db->prepare("INSERT INTO opcion(id_encuesta, texto) VALUE (?,?)");
        $sentencia->execute([$idEncuesta, $texto]);
    }
    
    public function getOpcionByText($texto){
        $sentencia = $this->db->prepare("SELECT * FROM opcion WHERE texto=?");
        $sentencia->execute([$texto]);
        $opcion = $sentencia->fetch(PDO::FETCH_OBJ);
        return $opcion;
    }
}
