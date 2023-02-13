<?php 

    include_once '../src/functions.php';
    
    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "inserir"){
        $gerenciamentoServico   = new GerenciamentoServico($grupo, $categoria);
        $gerenciamentoServico->insereGerenciamentoServico();
        header('Location: ../view/servicos_gerenciamento_agendamento.php?servico=inserido');
        die;
    }

?>