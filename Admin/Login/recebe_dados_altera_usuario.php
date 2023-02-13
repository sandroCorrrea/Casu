<?php 

    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    $pessoa             = new Pessoa();
    $endereco           = new EnderecoPessoa();

    extract($_POST);

    if(isset($alteraDadosPessoais)){
        $cpf                = formataCpfParaBancoDeDados($cpf);
        $estadoIdentidade   = explode("-", $identidade);
        $estadoIdentidade   = $estadoIdentidade[0];
        $numeroIdentidade   = explode("-", $identidade);
        $numeroIdentidade   = str_replace(".", "", $numeroIdentidade[1]);
    
        $pessoa->alteraDadosDaPessoa($nome, $cpf, $email, $dataNascimento, $estadoIdentidade, $numeroIdentidade, $codigo_pessoa);
    
        header('Location: ../view/dados_pessoais.php?acao=sucesso');
        die;
    }else{

        $cep = str_replace("-", "", $cep);
        
        $endereco->alteraEndereco($codigo_endereco_pessoa, $cep, $logradouro, $complemento, $bairro, $localidade, $uf, $ibge, $gia, $ddd, $siafi);

        header('Location: ../view/dados_pessoais.php?endereco=sucesso');
        die;
    }

?>