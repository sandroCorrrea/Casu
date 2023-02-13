<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    // Vamos retornar todos os dados do usuário Logado
    $pessoa     = new Pessoa();
    $todosDados = $pessoa->retornaTodosDadosDaPessoaEndereco($_SESSION['codigo_pessoa']);
    $todosDados = $todosDados[0];

    if(isset($_GET['acao']) && $_GET['acao'] == "sucesso"){
        $exibeMensagem = true;
    }else{
        $exibeMensagem = false;
    }

    if(isset($_GET['endereco']) && $_GET['endereco'] == "sucesso"){
        $exibeMensagemEndereco = true;
    }else{
        $exibeMensagemEndereco = false;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <link rel="shortcut icon" href="../Public/img/cropped-casufunec.webp" type="image/x-icon">

    <link href="../Public/css/estilo_administrador.css" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Hospital Irmã Denise - Administração</title>
</head>

<body id="page-top" onclick="removeListaAutoComplete();">

    <div id="wrapper">

        <!--===INCLUINDO SIDEBAR PADRÃO==-->
        <?php include '../view/sidebar.php';?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!--===INCLUINDO NAVBAR PADRÃO==-->
                <?php include '../view/navbar.php'?>

                <div class="container-fluid">

                    <h1 class="h3 mb-4 text-gray-800">Dados Pessoais</h1>

                    <div class="row">

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Minhas Informações Pessoais</h6>
                                </div>

                                <?php if($exibeMensagem){ ?>
                                    <div class="text-center mt-2">
                                        <p class="text-success">
                                            Dados Alterados Com Sucesso !
                                        </p>
                                    </div>
                                <?php }?>

                                <form action="../Login/recebe_dados_altera_usuario.php" method="POST" id="formularioSalvaDadosPessoais">
                                    
                                    <input type="hidden" name="alteraDadosPessoais" value="1">

                                    <input type="hidden" name="codigo_pessoa" value="<?=$_SESSION['codigo_pessoa']?>">

                                    <div class="card-body">
                                        <p>
                                            Abaixo estão listadas todas suas informações que foram informadas no ato do cadastro no site!
                                        </p>
    
                                        <div class="mb-2">
                                        
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label icon_nome_completo'></i>
    
                                                <label for="nomeCompleto" class="text-dark">Nome Completo:</label>
    
                                            </div>
    
    
                                            <input type="text" id="nomeCompleto" name="nome" class="form-control bg-primary text-light border-0 small" value="<?=$todosDados['nome']?>">                                        
    
                                        </div>
                                       
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label icon_cpf'></i>
    
                                                <label for="cpfUsuario" class="text-dark">Cpf:</label>
    
                                            </div>
    
                                            <input type="text" id="cpfUsuario" name="cpf" class="form-control bg-primary text-light border-0 small" value="<?=mask($todosDados['cpf'], "###.###.###-##") ?>">                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label icon_email'></i>
    
                                                <label for="emailUsuario" class="text-dark">E-mail:</label>
                                            </div>
                                            
                                            <input type="text" id="emailUsuario" name="email" class="form-control bg-primary text-light border-0 small" value="<?=$todosDados['email']?>">                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label icon_dataNascimento'></i>
    
                                                <label for="dataNascimentoUsuario" class="text-dark">Data de Nascimento:</label>
    
                                            </div>
    
                                            <input type="date" id="dataNascimentoUsuario" name="dataNascimento" class="form-control bg-primary text-light border-0 small" value="<?=$todosDados['data_nascimento']?>">                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label icon_identidade'></i>
    
                                                <label for="identidadeUsuario" class="text-dark">Identidade</label>
    
                                            </div>
    
                                            <input type="text" id="identidadeUsuario" name="identidade" class="form-control bg-primary text-light border-0 small" value="<?=$todosDados['estado_identidade'] . "-" . mask($todosDados['numero_identidade'], "##.###.###") ?>">                                        
                                            
                                        </div>
    
                                    </div>

                                    <div class="text-center mb-3 div_button_formulario">
                                        <button class="btn btn-facebook" type="button" id="botaoSalvarDadosPessoais">Salvar</button>
                                    </div>
                                    
                                </form>
                            </div>

                            <div class="card shadow mb-4">

                                <div class="card-header py-3">

                                    <h6 class="m-0 font-weight-bold text-primary">Detalhes Adicionais</h6>

                                </div>

                                <div class="card-body">

                                    <p>
                                        Abaixo seguem algumas informções adicionais que estão voltadas especificamente sobre o seu cadastro!
                                    </p>
                                    <i class='bx bx-calendar-alt'></i>
                                    <b>
                                        Data do Cadastro: <span class="text-success"><?=$todosDados['data_criacao_formatada']?></span> 
                                    </b>
                                    
                                    <hr class="sidebar-divider my-0">
                                    <i class='bx bx-calendar-alt'></i>
                                    <b>
                                        Data da Última Alteração: <span class="text-primary"><?=$todosDados['data_alteracao_formatada']?></span>
                                    </b>

                                    <div class="mt-4">
                                        <b class="btn btn-facebook btn-block">
                                            <i class='bx bx-check text-light icones__legenda'></i>
                                            Os ícones com esse marcador podem ser editados!
                                        </b>
                                    </div>

                                    <div class="mt-4">
                                        <b class="btn btn-facebook btn-block">
                                            <i class='bx bx-x text-light icones__legenda'></i>
                                            Os ícones com esse marcador não podem ser editados!
                                        </b>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Dados Do Meu Endereço</h6>
                                </div>

                                <?php if($exibeMensagemEndereco){ ?>
                                    <div class="text-center mt-2">
                                        <p class="text-success">
                                            Endereço Alterado Com Sucesso !
                                        </p>
                                    </div>
                                <?php }?>


                                <form action="../Login/recebe_dados_altera_usuario.php" method="post" id="formularioEnderecoPessoa">
                                    
                                    <input type="hidden" name="codigo_endereco_pessoa" value="<?=$_SESSION['codigo_endereco']?>">

                                    <div class="card-body">
                                        <p>
                                            Abaixo estão listados todos os dados referente ao seu endereço cadastrado!
                                        </p>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label'></i>
    
                                                <label for="cepUsuario" class="text-dark">Cep:</label>
    
                                            </div>
                                            
    
                                            <input type="text" id="cepUsuario" name="cep" class="form-control bg-primary text-light border-0 small" value="<?= mask($todosDados['cep'], "#####-###"); ?>">                                        
                                            
                                        </div>
    
                                        <div class="text-center">
                                            <button class="btn btn-facebook btn-sm" type="button" id="buscaDadosCep">
                                                Buscar Dados
                                            </button>
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="logradouroUsuario" class="text-dark">Logradouro:</label>
    
                                            </div>
    
                                            <input type="text" id="logradouroUsuario" name="logradouro" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['logradouro']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-check icones__legenda text-primary icones__label'></i>
    
                                                <label for="complementoUsuario" class="text-dark">Complemento:</label>
                                            </div>
    
                                            <input type="text" id="complementoUsuario" name="complemento" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['complemento']?>">                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="bairroUsuario" class="text-dark">Bairro:</label>
                                            </div>
    
                                            <input type="text" id="bairroUsuario" name="bairro" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['bairro']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="localidadeUsuario" class="text-dark">Localidade:</label>
    
                                            </div>
    
                                            <input type="text" id="localidadeUsuario" name="localidade" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['localidade']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
                                            
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="ufUsuario" class="text-dark">UF:</label>
    
                                            </div>
    
                                            <input type="text" id="ufUsuario" name="uf" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['uf']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="ibgeUsuario" class="text-dark">Código do IBGE:</label>
                                            </div>
    
                                            <input type="text" id="ibgeUsuario" name="ibge" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['ibge']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="giaUsuario" class="text-dark">GIA:</label>
    
                                            </div>
    
                                            <input type="text" id="giaUsuario" name="gia" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['gia']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="dddUsuario" class="text-dark">DDD:</label>
    
                                            </div>
    
                                            <input type="text" id="dddUsuario" name="ddd" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['ddd']?>" disabled>                                        
                                            
                                        </div>
    
                                        <div class="mb-2">
    
                                            <div class="label__icon">
    
                                                <i class='bx bx-x icones__legenda text-danger icones__label'></i>
    
                                                <label for="siafiUsuario" class="text-dark">SIAFI:</label>
    
                                            </div>
    
                                            <input type="text" id="siafiUsuario" name="siafi" class="form-control bg-primary text-light border-0 small" value="<?= $todosDados['siafi']?>" disabled>                                        
                                            
                                        </div>
    
                                    </div>

                                    <div class="text-center mb-3 div_button_formulario">
                                        <button class="btn btn-facebook" type="button" id="botaoSalvarDadosEndereco">Salvar</button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <footer class="sticky-footer bg-white">

                <div class="container my-auto">

                    <div class="copyright text-center my-auto">

                        <span>Copyright &copy; Desenvolvido por: <b>Agenda Contabilidade</b>, <?=date('Y')?></span>

                    </div>

                </div>
                
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once('../view/logout.php');?>                    

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../Public/js/jquery.mask.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

    <script src="../Public/js/dadosUsuario.js"></script>

</body>

</html>