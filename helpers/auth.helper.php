<?php

class AuthHelper{

    static public function estaLoggeadoAdmin() {
        if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
        }

        if (!isset($_SESSION['logged'])) { // Suponiendo una tabla usuarios(id, user, password)
            header('Location: ' . BASE_URL);
            die();
        }
    }

    static public function getIdUser() {
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }

        if (isset($_SESSION['logged'])){
        return $_SESSION['id'];
        }
    }

}