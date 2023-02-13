<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if(isset($tipo) && $tipo == "categorias"){

        $categorias                 = new ServicoCategoria();

        $ultimasCategorias          = $categorias->listaCategoriasRecentes();

        if($ultimasCategorias){

            foreach($ultimasCategorias AS $cadaCategoria){


                $quantidadeCategoria    = $categorias->retornaQuantidadeDeAgendamentosCategorias( $cadaCategoria['codigo_servico_categoria']);

                if(!$quantidadeCategoria['quantidade']){

                    // Vamos buscar o nome
                    $nomeCategoria          = $categorias->retornaDadosDaCategoria($cadaCategoria['codigo_servico_categoria']);

                    $arrayQuantidade[]      = array(
                        "quantidade"        => 0,
                        "nome"              => $nomeCategoria['nome']
                    );
                }else{
                    $arrayQuantidade[]      = array(
                        "quantidade"        => $quantidadeCategoria['quantidade'],
                        "nome"              => $quantidadeCategoria['nome']
                    );
                }
            }

            echo json_encode($arrayQuantidade);
            die;
        }else{

            $arrayQuantidade = array(
                "resultado"     => "erro"
            );

            echo json_encode($arrayQuantidade);
            die;
        }
    }
?>