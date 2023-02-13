<?php 

    include_once '../src/functions.php';
    
    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "editar"){

        // Vamos editar os dados da empresa
        $casu   = new Casu();

        $cnpj       = str_replace(".", "", $cnpj);
        $cnpj       = str_replace("/", "", $cnpj);
        $cnpj       = str_replace("-", "", $cnpj);

        $cep        = str_replace("-", "", $cep);

        $telefone    = str_replace("(", "", $telefone);
        $telefone    = str_replace(")", "", $telefone);
        $telefone    = str_replace("-", "", $telefone);

        $celular    = str_replace("(", "", $celular);
        $celular    = str_replace(")", "", $celular);
        $celular    = str_replace("-", "", $celular);

        $casu->alteraDadosEmpresa($nome_empresa, $cnpj, $cep, $rua, $bairro, $cidade, $uf, $numero, $telefone, $email, $inscricao_estadual, $tipo, $data_situacao_uf, $situacao_cnpj, $situacao_ie, $cnae_empresa, $nome_legivel, $celular);

        header("Location: {$url_retorno}");
        die;
    }

    
?>