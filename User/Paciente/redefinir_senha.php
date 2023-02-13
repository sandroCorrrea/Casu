<?php
include_once '../../Admin/src/functions.php';
include_once '../../Admin/PHPMailer-master/PHPMailerAutoload.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../../Admin/src/" . $class . ".php");
});

extract($_POST);

// Vamos verificar o e-mail informado
$paciente           = new Paciente();
$casu               = new Casu();
$resetaSenha        = $paciente->resetaSenhaPaciete($emailSenha);

if(!$resetaSenha){
    header('Location: ../view/index.php?senha=erro');
}else{
    // <-========= VAMOS INFORMAR PARA O PACIENTE SUAS CREDENCIAIS DE ACESSO ============->
    
    // Vamos enviar um e-mail contendo os dados do cadastro
    $imagemCabecalho    = dirname(__DIR__) . '\\Public\\img\\logo.png';
    $imagemCabecalho    = str_replace("User", "Admin", $imagemCabecalho);
    
    $imagemRodape       = dirname(__DIR__) . '\\Public\\img\\logo_recorte.png';
    $imagemRodape       = str_replace("User", "Admin", $imagemRodape);
    
    $imagemEmail        = dirname(__DIR__) . '\\Public\\img\\email.png';
    $imagemEmail        = str_replace("User", "Admin", $imagemEmail);
    
    $imagemTelefone     = dirname(__DIR__) . '\\Public\\img\\zap.png';
    $imagemTelefone     = str_replace("User", "Admin", $imagemTelefone);
    
    $emailAlerta        = new EnviaEmail($emailSenha, "Troca de Senha", $casu->nomeEmpresa, $imagemCabecalho, NULL, NULL, $imagemEmail, $imagemTelefone, NULL);
    
    $emailAlerta->redefinirSenha($resetaSenha, $emailSenha);

    header('Location: ../view/index.php?senha=sucesso');
}


?>