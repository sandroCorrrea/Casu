<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    // Vamos buscar todos itens da categoria que foi informada
    if(isset($codigo_categoria)){
        
        $agendamento                    = new Agendamento();

        // Vamos buscar todos os agendamentos criados por aquela categoria informada.
        $todosAgendamentosDaCategoria   = $agendamento->retornaTodosAgendamentosPorCategoria($codigo_categoria);

        if($todosAgendamentosDaCategoria){
            $todosAgendamentosDaCategoria   = json_encode($todosAgendamentosDaCategoria);
        }else{
            $todosAgendamentosDaCategoria = array(
                "resultado" => "erro"
            );

            $todosAgendamentosDaCategoria = json_encode($todosAgendamentosDaCategoria);
        }
        echo $todosAgendamentosDaCategoria;
        die;
    }

?>