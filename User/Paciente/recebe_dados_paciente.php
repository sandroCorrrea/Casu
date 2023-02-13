<?php
include_once '../../Admin/src/functions.php';
include_once '../../Admin/PHPMailer-master/PHPMailerAutoload.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../../Admin/src/" . $class . ".php");
});

extract($_POST);

if (isset($acao)) {
    // Vamos verificar se o usário em questão possui cadastro realizado
    $pacienteAcesso     = new PacienteAcesso();
    $acesso             = $pacienteAcesso->verificaAcessoUsuario($login, $senha);

    if ($acesso) {

        $codigoPaciente = $acesso[0]['codigo_paciente'];
        $paciente       = new Paciente();
        $dadosPaciente  = $paciente->retornaTodosDadosDoPaciente($codigoPaciente);
        $dadosPaciente  = $dadosPaciente[0];

        $primeiroNome   = explode(" ", $dadosPaciente['nome_paciente']);
        $primeiroNome   = ucfirst($primeiroNome[0]);

        // Vamos criar uma sessão para o paciente em questão
        session_start();

        $_SESSION['nome']               = $primeiroNome;
        $_SESSION['codigo_paciente']    = $codigoPaciente;
        $_SESSION['codigo_endereco']    = $dadosPaciente['codigo_endereco'];
        $_SESSION['login']              = $dadosPaciente['login_paciente'];
        $_SESSION['cpf']                = $dadosPaciente['cpf_paciente'];
        $_SESSION['not_promo']          = $dadosPaciente['notificacoes_promocoes'];
        $_SESSION['not_consu']          = $dadosPaciente['notificacoes_consultas'];


        // Vamos encaminhar o usuário para interface de consultas
        header('Location: ../view/consulta.php');
        die;
    } else {
        header('Location: ../view/index.php?login=erro');
        die;
    }
} else {
    $casu               = new Casu();

    $cep                = str_replace("-", "", $cep);
    $cpf                = str_replace(".", "", $cpf);
    $cpf                = str_replace("-", "", $cpf);
    $celular_paciente   = str_replace("(", "", $celular_paciente);
    $celular_paciente   = str_replace(")", "", $celular_paciente);
    $celular_paciente   = str_replace("-", "", $celular_paciente);
    $numero_identidade  = str_replace(".", "", $numero_identidade);
    $telefone_paciente  = str_replace("(", "", $telefone_paciente);
    $telefone_paciente  = str_replace(")", "", $telefone_paciente);
    $telefone_paciente  = str_replace("-", "", $telefone_paciente);

    // <-========= VAMOS VERIFICAR SE O PACIENTE JÁ NÃO EXISTE ============->
    $verificaPaciente   = new Paciente();
    $acessoPaciente     = $verificaPaciente->verificaPacienteExistente($cpf, $emailPaciente);

    if ($acessoPaciente) {

        // <-========= VAMOS INSERIR O ENDEREÇO DO PACIENTE ============->
        $enderecoPessoa = new EnderecoPaciente($cep, $logradouro, $complemento, $bairro, $localidade, $uf, $ibge, $gia, $ddd, $siafi);
        $enderecoPessoa->insereEndereco();

        // <-========= VAMOS INSERIR O PACIENTE ============->
        $codigoEndereco = $enderecoPessoa->retornaUltimoCodigoTabela("paciente_endereco", "codigo_endereco_paciente");
        $codigoEndereco = $codigoEndereco[0]['codigo'];

        $paciente       = new Paciente($primeiroNomePaciente . " " . $sobrenome, $cpf, $data_nascimento_paciente, $emailPaciente, $telefone_paciente, $celular_paciente, $numero_identidade, $orgao_expeditor, $estado_identidade, $codigoEndereco);
        $paciente->inserePaciente();

        // <-========= VAMOS INSERIR AS PREFERÊNCIAS DO PACIENTE ============->
        $codigoPaciente = $paciente->retornaUltimoCodigoTabela("paciente", "codigo_paciente");
        $codigoPaciente = $codigoPaciente[0]['codigo'];

        if (isset($notificacoes_promocionais)) {
            $promocao = "sim";
        } else {
            $promocao = "nao";
        }

        if (isset($notificacao_consulta)) {
            $consulta = "sim";
        } else {
            $consulta = "nao";
        }

        $notificacoes   = new NotificacaoPaciente($promocao, $consulta, $codigoPaciente);
        $notificacoes->insereNotificacao();

        // <-========= VAMOS CRIAR UM LOGIN PARA O PACIENTE ============->
        $dataSenha      = str_replace("-", "", $data_nascimento_paciente);

        $pacienteAcesso = new PacienteAcesso($codigoPaciente, $cpf . $dataSenha, $emailPaciente, "ativo");
        $pacienteAcesso->insereUsuario();

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

        $emailAlerta        = new EnviaEmail($emailPaciente, "Cadastro criado com sucesso !", $casu->nomeEmpresa, $imagemCabecalho, NULL, NULL, $imagemEmail, $imagemTelefone, NULL);

        $emailAlerta->enviaEmailConfirmaCadastroPaciente($cpf.$dataSenha, $emailPaciente, ucfirst($primeiroNomePaciente));

        // Vamos enviar uma mensagem via wpp para o paciente.
        $numeroCelularFormatado = formataNumeroWpp($celular_paciente);

        $primeiroNomePaciente   = ucfirst($primeiroNomePaciente);
        $mensagemCadastro       = "Olá {$primeiroNomePaciente} obrigado por realizar seu cadastro!\n";
        $mensagemCadastro      .= "Seguem abaixo suas credenciais de acesso ao sistema:\n";
        $mensagemCadastro       .= "*Login:*    {$emailPaciente}\n";
        $mensagemCadastro       .= "*Senha*:    {$cpf}{$dataSenha}\n";
        $mensagemCadastro       .= "*Link de acesso:*   http://{$_SERVER['REMOTE_ADDR']}/Casu/User/view/index.php";
        
        $mensagemCadastro       = urlencode($mensagemCadastro);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://wpp-casu.herokuapp.com/send-message");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,"number={$numeroCelularFormatado}&message={$mensagemCadastro}");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        header('Location: ../view/index.php?cadastro=sucesso');
        die;
    } else {
        header('Location: ../view/index.php?erro=cadastro');
        die;
    }
}
