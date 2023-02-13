<?php 

    include_once '../src/functions.php';
    include_once '../PHPMailer-master/PHPMailerAutoload.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    $pessoa         = new Pessoa();
    $casu           = new Casu();
    $resetaSenha    = $pessoa->alteraSenhaPessoa($emailSenha);

    if($resetaSenha){

        // Vamos enviar um e-mail contendo os dados da troca de senha
        $imagemCabecalho    = dirname(__DIR__).'\\Public\\img\\logo.png';
        $imagemRodape       = dirname(__DIR__).'\\Public\\img\\logo_recorte.png';
        $imagemEmail        = dirname(__DIR__).'\\Public\\img\\email.png';
        $imagemTelefone     = dirname(__DIR__).'\\Public\\img\\zap.png';

        $email  = new EnviaEmail($emailSenha, "Redefinição de Senha",$casu->nomeEmpresa, $imagemCabecalho, $imagemRodape, NULL, $imagemEmail, $imagemTelefone, NULL);

        $email->redefinirSenha($resetaSenha, $emailSenha);

        header('Location: ../../User/view/administrador.php?email=sucesso');
        die;
    }else{
        header('Location: ../../User/view/administrador.php?email=erro');
        die;
    }

?>