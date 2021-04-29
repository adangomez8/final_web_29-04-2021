<?php
    require_once('libs/smarty/Smarty.class.php');

class UsuarioView{

    private $smarty;

    public function __construct(){
        $this->smarty = new Smarty();
        $this->smarty->assign('base_url', BASE_URL);
    }
}