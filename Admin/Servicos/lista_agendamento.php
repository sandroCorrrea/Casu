<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    $agendamento        = new Agendamento();
    $nomeAgendamento    = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);

    if(!empty($nomeAgendamento)){

        $retornaDadosAgendamento    = $agendamento->pesquisaAgendamentoPorNome($nomeAgendamento);

        if($retornaDadosAgendamento){

            $retorno = array(
                "erro"      => false,
                "dados"  => $retornaDadosAgendamento
            );
        }else{
            $retorno = array(
                "erro"      => true,
                "mensagem"  => "Nenhum agendamento encontrado !"
            );
        }

    }else{

        $retorno = array(
            "erro"      => true,
            "mensagem"  => "Nenhum agendamento encontrado !"
        );
    }

    echo json_encode($retorno);
?>