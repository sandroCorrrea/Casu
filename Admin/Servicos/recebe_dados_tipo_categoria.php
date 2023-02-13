<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "inserir"){
        $categoriaTipo      = new ServicoCategoriaTipo($nome, $descricao, $categoria);
        $categoriaTipo->insereServicoCategoria();

        header('Location: ../view/servico_categoria_tipo.php?servico=inserido');
        die;
    }else{
        $categoriaTipo      = new ServicoCategoriaTipo();
        
        $categoriaTipo->alteraTipoCategoria($codigoCategoria, $nome, $descricao, $categoria);
        header('Location: ../view/servico_categoria_tipo.php?servico=alterado');
        die;
    }

?>