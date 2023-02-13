<?php 

    include_once '../src/functions.php';
    include_once '../PHPMailer-master/PHPMailerAutoload.php';
    
    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "inserir"){

        $agendamento    = new Agendamento($nome_agendamento, $data_agendamento, $horario, $codigo_responsavel, $localAtendimento, $vagas_agendamento, $categoria_agendamento, $valor);
        
        $agendamento->insereAgendamento();

        header('Location: ../view/agendamento.php?inserido=sucesso');
        die;
    }else if($acao == "editar"){
        
        $agendamento    = new Agendamento();
        $agendamento->editarAgendamento($codigo_agendamento, $nome_agendamento, $hora, $data, $codigo_pessoa, $local, $vagas, $categoria, $valor);
        header('Location: ../view/servico_agendamento.php?alterado=sucesso');
        die;
    }else{
        $agendamento    = new Agendamento();
        $agendamento->excluirAgendamento($codigo_agendamento);
        header('Location: ../view/servico_agendamento.php?excluido=sucesso');
        die;
    }
?>