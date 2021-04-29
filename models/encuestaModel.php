<?php

class EncuestaModel {
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

    public function getEncuestaById($id){
        $sentencia = $this->db->prepare("SELECT * FROM encuesta WHERE id=?");
        $sentencia->execute([$id]);
        $encuesta = $sentencia->fetch(PDO::FETCH_OBJ);
        return $encuesta;
    }

    public function getMismoTituloEncuesta($titulo){
        $sentencia = $this->db->prepare("SELECT * FROM encuesta WHERE titulo=?");
        $sentencia->execute([$titulo]);
        $encuesta = $sentencia->fetch(PDO::FETCH_OBJ);
        return $encuesta;
    }

    public function nuevaEncuesta($titulo, $descripcion, $multiple){
        $sentencia = $this->db->prepare("INSERT INTO encuesta(titulo, descripcion, multiple) VALUE (?,?,?)");
        $sentencia->execute([$titulo, $descripcion, $multiple]);
    }
}