<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    $paciente       = new Paciente();
    $todosPacientes = $paciente->retornaTodosDadosDoPaciente(NULL);
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

    <title>Hospital Irmã Denise - Usuários</title>
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

                    <h1 class="h3 mb-1 text-gray-800">
                        Usuários que realizaram cadastros (Pacientes).
                    </h1>
                    <p class="mb-4">

                        <p>
                            <b>
                                Abaixo estão sendo listados todos os usuários que realizaram o cadastro:
                            </b>
                        </p>

                    </p>

                    <div class="row">

                        <div class="col-lg-12">

                            <?php if($todosPacientes){?>
                                <div class="card mb-4 py-3 border-left-primary card-listagem-paciente">
                                    <div class="card-body">
                                        <?php foreach($todosPacientes AS $key => $cadaPaciente){?>

                                            <p>
                                                <b>
                                                    <i class='bx bx-user text-primary'></i>  <?=$cadaPaciente['nome_paciente']?>
                                                </b>
                                                
                                                <b class="dadosModalPaciente">
                                                    <span class="text-primary">-</span> <a href="#" data-toggle="modal" data-target="#modalExibeDadosPaciente<?=$key?>">Dados</a>
                                                </b> 

                                            </p>

                                            <hr>
                                            
                                            <!-- Modal Para exibir informações do paciente -->
                                            <div class="modal fade" id="modalExibeDadosPaciente<?=$key?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                <i class='bx bx-user text-primary'></i> Dados do Paciente:
                                                            </h5>

                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>

                                                        </div>

                                                        <div class="modal-body">

                                                            <div class="header text-primary">
                                                                <h4>Dados Pessoais:</h4>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col">
                                                                    <label for="nome">Nome Completo:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['nome_paciente']?>" id="nome" disabled>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">
                                                                    <label for="cpf">CPF:</label>
                                                                    <input type="text" class="form-control" value="<?= mask($cadaPaciente['cpf_paciente'], '###.###.###-##')?>" id="cpf" disabled>
                                                                </div>
                                                                
                                                                <div class="col">
                                                                    <label for="dataNascimento">Data Nascimento:</label>
                                                                    <input type="date" class="form-control" value="<?=$cadaPaciente['data_nascimento']?>" id="dataNascimento" disabled>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">
                                                                    <label for="email">E-mail:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['login_paciente']?>" id="email" disabled>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">
                                                                    <label for="telefone">Telefone:</label>

                                                                    <?php if($cadaPaciente['telefone']){?>
                                                                        <input type="text" class="form-control" value="<?= mask($cadaPaciente['telefone'], '(##)####-####')?>" id="telefone" disabled>
                                                                    <?php }else {?>
                                                                        <input type="text" class="form-control" value="" id="telefone" disabled>
                                                                    <?php }?>
                                                                    
                                                                </div>

                                                                <div class="col">
                                                                    <label for="celular">Celular:</label>
                                                                    <input type="text" class="form-control" value="<?= mask($cadaPaciente['celular'], '(##)#####-####')?>" id="celular" disabled>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">
                                                                    <label for="numeroIdentidade">Número Identidade:</label>
                                                                    <input type="text" class="form-control" value="<?= mask($cadaPaciente['numero_identidade'], '##.###.###')?>" id="numeroIdentidade" disabled>
                                                                    
                                                                </div>

                                                                <div class="col">
                                                                    <label for="orgaoExpeditor">Orgão Expeditor Identidade:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['orgao_expeditor_identidade']?>" id="orgaoExpeditor" disabled>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="ufIdentidade">UF Identidade:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['uf_identidade']?>" id="ufIdentidade" disabled>
                                                                </div>

                                                            </div>

                                                            <hr>

                                                            <div class="header text-primary">
                                                                <h4>Dados do Endereço:</h4>
                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">

                                                                    <label for="cep">CEP:</label>
                                                                    <input type="text" class="form-control" value="<?= mask($cadaPaciente['cep'], '#####-###')?>" id="cep" disabled>
                                                                    
                                                                </div>

                                                                <div class="col">
                                                                    <label for="bairro">Bairro:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['bairro']?>" id="bairro" disabled>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="localidade">Localidade:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['localidade']?>" id="localidade" disabled>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">
                                                                    
                                                                <div class="col">

                                                                    <label for="logradouro">Logradouro:</label>
                                                                    <input type="text" class="form-control" value="<?= $cadaPaciente['logradouro']?>" id="logradouro" disabled>

                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">
                                                                    
                                                                <div class="col">

                                                                    <label for="complemento">Complemento:</label>
                                                                    <input type="text" class="form-control" value="<?= $cadaPaciente['complemento']?>" id="complemento" disabled>

                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">

                                                                    <label for="ibge">Código IBGE:</label>
                                                                    <input type="text" class="form-control" value="<?= $cadaPaciente['ibge']?>" id="ibge" disabled>
                                                                    
                                                                </div>

                                                                <div class="col">
                                                                    <label for="ddd">DDD:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['ddd']?>" id="ddd" disabled>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="siafi">Código SIAFI:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['siafi']?>" id="siafi" disabled>
                                                                </div>

                                                            </div>

                                                            <hr>

                                                            <div class="header text-primary">
                                                                <h4>Dados Complementares:</h4>
                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">

                                                                    <label for="dataCriacao">Data e Hora do Cadastro:</label>
                                                                    <input type="text" class="form-control" value="<?= $cadaPaciente['data_criacao_paciente']?>" id="dataCriacao" disabled>
                                                                    
                                                                </div>

                                                                <div class="col">
                                                                    <label for="atualizacao">Data e Hora da última Atualização:</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaPaciente['data_atualizacao_paciente']?>" id="atualizacao" disabled>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger" type="button" data-dismiss="modal">Fechar</button>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>



                                        <?php }?>
                                    </div>
                                </div>
                            <?php }else {?>
                                <div class="card mb-4 py-3 border-left-danger">
                                    <div class="card-body text-danger">
                                        <i class='bx bx-info-circle'></i>   Ainda não encontramos nenhum paciente <b>cadastrado</b> !
                                    </div>
                                </div>
                            <?php }?>

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
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

</body>

</html>