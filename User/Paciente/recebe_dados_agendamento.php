<?php
    include_once '../../Admin/src/functions.php';
    include_once '../../Admin/PHPMailer-master/PHPMailerAutoload.php';
    
    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../../Admin/src/".$class.".php");
    });

    extract($_POST);

    $agendamento            = new Agendamento();

    if(isset($_POST['acao']) && $_POST['acao'] == "inserir"){
        
        // Vamos inserir o agendamento do paciente
        $pacienteConsulta   = new PacienteConsulta($codigo_paciente, $codigo_agendamento);

        // Antes vamos verificar se o mesmo já não marcou a consulta
        $agendamentoJaFeito = $pacienteConsulta->verificaAgendamentoJaFeito($codigo_paciente, $codigo_agendamento);        

        if($agendamentoJaFeito){
            $pacienteConsulta->inserePacienteConsulta();
    
            // Vamos atualizar o número de vagas do agendamento.
            $agendamento->atualizaNumeroDeVagasAgendamento($codigo_agendamento);
            
            header('Location: ../view/agendamento.php?agendamento=sucesso');
            die;
        }else{
            header('Location: ../view/agendamento.php?agendamento=erro');
            die;
        }
    }
?>