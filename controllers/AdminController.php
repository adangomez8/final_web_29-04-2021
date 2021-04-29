<?php

require_once 'models/opcionModel.php';
require_once 'models/encuestaModel.php';
require_once 'models/respuestaModel.php';
require_once 'models/votacionModel.php';
require_once 'views/view.php';
require_once 'helpers/autentication.helper.php';


class AdminController{

    private $opcionModel;
    private $encuestaModel;
    private $respuestaModel;
    private $usuarioModel;
    private $view;

    public function __construct() {
        $this->opcionModel = new OpcionModel();
        $this->encuestaModel = new EncuestaModel();
        $this->respuestaModel = new RespuestaModel();
        $this->usuarioModel = new UsuarioModel();
        $this->view = new UsuarioView();
        AuthHelper::estaLoggeadoAdmin();//Compruebo que el usuario está loggeado
    }

    public function formEncuesta(){
        $this->view->formEncuesta(); // Creo formulario de la encuestas en la vista
    }

    public function confirmAltaEncuesta(){
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $multiple = $_POST['multiple'];

        $encuestaConMismoTitulo = $this->encuestaModel->getMismoTituloEncuesta($titulo);

        if(!empty($encuestaConMismoTitulo)){
            $this->view->formEncuesta( "Ya existe encuesta con el título" . $titulo);
        } else if (empty ($titulo)||empty ($descripcion)||empty ($multiple)){
            $this->view->formEncuesta("Faltan campos por completar");
        } else if ($multiple=0){
            $this->encuestaModel->nuevaEncuesta($titulo, $descripcion, $multiple);
            $idEncustaRecienCreada = $encuestaConMismoTitulo->id;
            $this->opcionModel->nuevaOpcion($idEncustaRecienCreada, 'Si');
            $this->opcionModel->nuevaOpcion($idEncustaRecienCreada, 'No'); 
        } else {
            $this->encuestaModel->nuevaEncuesta($titulo, $descripcion, $multiple);
        }
    }


    public function buscarIdEncuesta(){
        $this->view->formbuscarIdEncuesta();//El usuario va a ingresar un id de la encuesta que quiere ver los resultados
    }

    public function resultadosEncuestaXId(){
        $id = $_POST['id'];

        $encuestaConId = $this->encuestaModel->getEncuestaById($id);

        if(!empty($encuestaConId)){
            $this->view->formbuscarIdEncuesta( "No existe encuesta con el ID" . $id);
        } else{
            $titulo = $encuestaConId->titulo;
            $this->view->verTituloEncuesta($titulo);
            $respuestasDeEncuesta = $this->respuestaModel->getRespuestasEncuesta($id);
            foreach($respuestasDeEncuesta as $respuesta){
                $totalRespuestas = 0;
                $opcionesDeEncuesta = $this->opcionModel->getOpcionesDeEncuesta($id);
                foreach ($opcionesDeEncuesta as $opcion){
                    $cantVotantesXOpcion = count($opcion->id);
                    $totalRespuestas += $cantVotantesXOpcion;
                    $this->view->verRespuestasEncuesta($respuesta, $opcion, $cantVotantesXOpcion);
                }
                $this->view->verTotalRespuestas($totalRespuestas);    
            }

        }
    }

    public function buscarTituloYOpcionEncuesta(){
        $this->view->FormbuscarTituloYOpcionEncuesta();
    }

    public function resultadosEncuestaXTitYOpc(){
        $titulo = $_POST['titulo'];
        $textoOpcion = $_POST['textoOpcion']; 

        $encuesta = $this->encuestaModel->getMismoTituloEncuesta($titulo);
        $opcion = $this->opcionModel->getOpcionByText($textoOpcion);
        $idUsuario = AuthHelper::getIdUser();
        $respuestaDeUsuario = $this->respuestaModel->getRespuestaDeUsuario($idUsuario->id);
        
        if(!empty($encuesta)){
            $this->view->FormbuscarTituloYOpcionEncuesta( "No existe encuesta con el título" . $titulo);
        } else if (!empty($textoOpcion)){
            $this->view->FormbuscarTituloYOpcionEncuesta( "No existe la opción" . $opcion);
        } else if(empty($respuestaDeUsuario)){
            $this->view->FormbuscarTituloYOpcionEncuesta( "Ya votaste anteriormente esta opción");
        } else{
            $this->respuestaModel->votarXRespuesta($opcion->id, $encuesta->id, $idUsuario);
        }
    }

    
}