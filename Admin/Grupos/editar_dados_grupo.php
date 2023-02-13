<?php 

    include_once '../src/functions.php';
    
    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "editar"){
        $grupo      = new Grupo();

        // Vamos editar todos os dados do grupo Informado
        $grupo->alteraDadosDoGrupo($nomeGrupoCriado, $descricaoGrupoCriado, $codigo_grupo);

        header('Location: ../view/administradores.php?grupo=alterado');
        die;
    }
?>