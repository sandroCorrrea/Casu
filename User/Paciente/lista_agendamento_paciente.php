<?php
    include_once '../../Admin/src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../../Admin/src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    $agendamento        = new Agendamento();
    $nomeAgendamento    = filter_input(INPUT_GET, 'nomeAgendamento', FILTER_SANITIZE_STRING);
    $codigoPaciente     = $_SESSION['codigo_paciente'];

    if(!empty($nomeAgendamento)){

        $retornaDadosAgendamento    = $agendamento->retornaTodasConsultaDoPacientePorNome($codigoPaciente, $nomeAgendamento);

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