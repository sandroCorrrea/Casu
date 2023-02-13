<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    $agendamento        = new Agendamento();

    if(isset($tipo) && $tipo == "agendamentos"){

        for($i = 1; $i <= 12; $i++){

            if(strlen($i) == 1){
                $i = "0".$i;
            }else{
                $i = $i;
            }

            $cadaAgendamento[$i] = array(
                $i  => $agendamento->retornaAgendamentosAgrupadosPorMes($i)
            );
        }

        echo json_encode($cadaAgendamento);
        die;
    }
?>