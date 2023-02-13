<?php 

    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if(isset($logout) && $_POST['logout'] == "confirma"){
        verificaSessaoUsuario("1");
        header('Location: ../../User/view/administrador.php');
        die;
    }

?>