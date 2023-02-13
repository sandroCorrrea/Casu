<?php 

    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);
    
    $pessoaAcesso   = new PessoaAcesso();

    // <-===== Vamos verificar se a pessoa em questão possui acesso ao não ====->
    $verificaLogin  = $pessoaAcesso->verificaAcessoUsuario($login, $senha);

    
    if($verificaLogin){
        
        // Vamos buscar Todos os Dados da pessoa e montar nossa sessão.
        $pessoa         = new Pessoa();
        $dadosPessoa    = $pessoa->retornaTodosDadosDePessoa($verificaLogin[0]['codigo_pessoa']);
        
        unset($_SESSION);

        // Vamos iniciar uma sessão
        session_start();

        $nomeFormatado  = explode(" ", $dadosPessoa[0]['nome_pessoa']);
        $nomeFormatado  = $nomeFormatado[0];
        $nomeFormatado  = ucfirst($nomeFormatado);

        if(!isset($_SESSION['login'])){
            $_SESSION['nome']               = $dadosPessoa[0]['nome_pessoa'];
            $_SESSION['codigo_pessoa']      = $dadosPessoa[0]['codigo_pessoa'];
            $_SESSION['login']              = $dadosPessoa[0]['login'];
            $_SESSION['codigo_endereco']    = $dadosPessoa[0]['codigo_endereco'];
            $_SESSION['nome_grupo']         = $dadosPessoa[0]['nome_grupo'];
            $_SESSION['codigo_grupo']       = $dadosPessoa[0]['codigo_grupo'];
            $_SESSION['nome_formatado']     = $nomeFormatado;
        }

        header('Location: ../view/painel_administrador.php?msg=sucesso');
        die;
    }else{
        // Vamos retorna oque está inválido via GET
        header('Location: ../../User/view/administrador.php?msg=erro');
        die;
    }
?>