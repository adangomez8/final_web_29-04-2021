<?php

class RespuestaModel {
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
    public function getRespuestasEncuesta($id){
        $sentencia = $this->db->prepare("SELECT * FROM respuestas WHERE id_encuesta=?");
        $sentencia->execute([$id]);
        $respuesta = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $respuesta;
    }

    public function getRespuestaDeUsuario($idUseuario){
        $sentencia = $this->db->prepare("SELECT * FROM respuesta WHERE id_usuario=?");
        $sentencia->execute([$idUseuario]);
        $opcion = $sentencia->fetch(PDO::FETCH_OBJ);
        return $opcion;
    }

    public function votarXRespuesta($idOpcionid, $idEncuesta, $idUsuario){
        $sentencia = $this->db->prepare("INSERT INTO respuesta VALUE(id_opcion, id_encuesta, id_usuario) (?,?,?)");
        $sentencia->execute([$idOpcionid, $idEncuesta, $idUsuario]);
    }
}
