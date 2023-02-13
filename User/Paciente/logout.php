<?php 

    include_once '../../Admin/src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../../Admin/src/".$class.".php");
    });

    if($_POST['acao'] == "deslogar"){

        verificaSessaoUsuario("1");

        unset($_SESSION);

        header("Location: ../view/index.php");
        die;
    }
?>