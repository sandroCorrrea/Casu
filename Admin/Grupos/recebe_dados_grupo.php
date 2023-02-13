<?php 

    include_once '../src/functions.php';
    include_once '../PHPMailer-master/PHPMailerAutoload.php';
    
    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    extract($_POST);

    if($acao == "inserirGrupo"){
        $grupo = new Grupo($nomeGrupo, $descricaoGrupo);

        $grupo->insereGrupo();

        header('Location: ../view/administradores.php?sucesso=grupo');
        die;
    }else{

        $casu               = new Casu();
        $cep                = str_replace("-", "", $cepColaborador);

        // Vamos Inserir os Dados referente ao Endereço da Pessoa.
        $enderecoPessoa     = new EnderecoPessoa($cep, $logradouro, $complemento, $bairro, $localidade, $uf, $ibge, $gia, $ddd, $siafi);
        $enderecoPessoa->insereEndereco();

        $codigoEndereco     = $enderecoPessoa->retornaUltimoCodigoTabela("pessoa_endereco", "codigo_endereco_pessoa");
        $codigoEndereco     = $codigoEndereco[0]['codigo'];

        // Vamos Inserir os Dados referente aos dados Pessoais da Pessoa.
        $cpf                = formataCpfParaBancoDeDados($cpfColaborador);
        $numeroIdentidade   = str_replace(".", "", $numeroIdentidadeColaborador);

        $pessoa             = new Pessoa($nomeCompleto,  $cpf, $emailColaborador, $dataNascimentoColaborador, $estadoIndentidade, $numeroIdentidade, $codigoEndereco);
        $pessoa->inserePessoa();

        // Vamos Inserir os Dados referente ao Grupo da Pessoa.
        $pessoaGrupo        = new Grupo();
        $codigoColaborador  = $pessoaGrupo->retornaUltimoCodigoTabela("pessoa", "codigo_pessoa");
        $codigoColaborador  = $codigoColaborador[0]['codigo'];

        $pessoaGrupo->inserePessoaGrupo($codigoColaborador, $grupoColaborador);


        // Vamos Inserir os Dados referente ao Acesso da Pessoa.
        $pessoaAcesso   = new PessoaAcesso($codigoColaborador, $grupoColaborador."_".$cpf, $emailColaborador);
        $pessoaAcesso->insereUsuario();


        // Vamos enviar um e-mail contendo os dados do cadastro
        $imagemCabecalho    = dirname(__DIR__).'\\Public\\img\\logo.png';
        $imagemRodape       = dirname(__DIR__).'\\Public\\img\\logo_recorte.png';
        $imagemEmail        = dirname(__DIR__).'\\Public\\img\\email.png';
        $imagemTelefone     = dirname(__DIR__).'\\Public\\img\\zap.png';

        $emailCadastro  = new EnviaEmail($emailColaborador, "Confirmação de Acesso !",$casu->nomeEmpresa, $imagemCabecalho, $imagemRodape, NULL, $imagemEmail, $imagemTelefone, NULL);

        $nomeDoGrupo    = $pessoaGrupo->retornaTodosDadosDoGrupo($grupoColaborador);
        $nomeDoGrupo    = $nomeDoGrupo[0]['nome'];

        $nomePessoa     = explode(" ", $pessoa->nome);
        $nomePessoa     = ucfirst($nomePessoa[0]) . " ".ucfirst($nomePessoa[1]);

        $emailCadastro->enviaEmailConfirmaCadastro($grupoColaborador."_".$cpf, $emailColaborador, $nomeDoGrupo, $nomePessoa);

        header('Location: ../view/administradores.php?user=sucesso');
        die;
    }
?>