<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "inserir"){

        // Vamos inserir a categoria do serviço
        $servicoCategoria   = new ServicoCategoria($nome, $descricao, $status);

        $servicoCategoria->insereServicoCategoria();
        header('Location: ../view/servico_categoria.php?servico=inserido');
        die;
    }else{
        $servicoCategoria   = new ServicoCategoria($nome, $descricao, $status);

        $servicoCategoria->alteraCategoria($codigoCategoria, $nome, $descricao, $status);
        header('Location: ../view/servico_categoria.php?servico=alterado');
        die;
    }
?>