<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    $solicitacao = new Solicitacoes();

    if($status){
        foreach($status AS $cadaStatus){

            $codigo_paciente_atendimento    = explode("-", $cadaStatus);
            $status_paciente_atendimento    = $codigo_paciente_atendimento[0];
            $codigo_paciente_atendimento    = end($codigo_paciente_atendimento);

            $solicitacao->atualizaStatusSolicitacao($codigo_paciente_atendimento, $status_paciente_atendimento);
        }

        header('Location: ../view/solicitacoes.php?alteracao=sucesso');
        die;
    }
?>