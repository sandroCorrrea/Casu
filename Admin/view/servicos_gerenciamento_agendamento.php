<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    $grupos         = new Grupo();
    $categorias     = new ServicoCategoria();
    // $gerenciamento  = new GerenciamentoServico();

    $todosGrupos            = $grupos->retornaTodosGruposCadastrados();
    $todasCategorias        = $categorias->listaTodasCategorias();
    $todosGerenciamentos    = $gerenciamento->listaTodosServicosAgendamento();

    if(isset($_GET['servico']) && $_GET['servico'] == "inserido"){
        $exibeMensagemServico = true;
    }else{
        $exibeMensagemServico = false;
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

    <title>Hospital Irmã Denise - Serviços Gerenciamento de Categorias</title>
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

                    <h1 class="h3 mb-1 text-gray-800">Gerenciamento de Agendamentos</h1>
                    <p class="mb-4">
                        Crie abaixo grupos que poderão criar consultas, exames etc... .Esses grupos quando criarem seus respectivos serviços irão aparecer como disponível diretamente na interface do paciente.
                    </p>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-lg-6">

                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Categorias e Grupos</h6>
                                </div>

                                <?php if($exibeMensagemServico){?>
                                    <div class="header text-center mt-2">
                                        <p>
                                            <b class="text-success">
                                                Gerenciamento criado com sucesso !
                                            </b>
                                        </p>
                                    </div>
                                <?php }?>

                                <div class="card-body">
                                    Selecione um tipo de serviço e um grupo. Os mesmo selecionados irão ter o poder de criar serviços.

                                    <form action="../Grupos/gerenciamento_servicos.php" method="post" id="formulario_gerenciamento_servico">

                                        <input type="hidden" name="acao" value="inserir">

                                        <div class="mt-2">

                                            <label for="grupos" class="label_grupos">Grupos:</label>

                                            <select name="grupo" id="grupos" class="form-control">

                                                <?php if($todosGrupos) {?>

                                                    <option value="selecione" selected> -- SELECIONE -- </option>

                                                    <?php foreach($todosGrupos AS $cadaGrupo){?>
                                                        
                                                        <option value="<?=$cadaGrupo['codigo_grupo']?>"><?=$cadaGrupo['nome']?></option>

                                                    <?php }?>

                                                <?php } else {?>
                                                    <option value="selecione">Não Existem Grupos Cadastrados !</option>
                                                <?php }?>

                                            </select>
                                        
                                        </div>

                                        <div class="mt-2">

                                            <label for="categorias" class="label_categorias">Categorias:</label>
                                            
                                            <select name="categoria" id="categorias" class="form-control">

                                                <?php if($todasCategorias) {?>

                                                    <option value="selecione" selected> -- SELECIONE -- </option>

                                                    <?php foreach($todasCategorias AS $cadaCategoria){?>
                                                        
                                                        <option value="<?=$cadaCategoria['codigo_servico_categoria']?>"><?=$cadaCategoria['nome']?></option>

                                                    <?php }?>

                                                <?php } else {?>
                                                    <option value="selecione">Não Existem Categorias Cadastrados !</option>
                                                <?php }?>

                                            </select>
                                        
                                        </div>

                                        <hr>

                                        <div class="botao_agendamento_servico text-center">
                                            <button class="btn btn-facebook" type="button" id="botao_agendamento_servico">Salvar</button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Listagem de Gerenciamentos</h6>
                                </div>
                                <div class="card-body">
                                    <?php if($todosGerenciamentos){?>

                                        <?php foreach($todosGerenciamentos AS $key => $cadaGerenciamento){?>
                                            
                                            <p>
                                                <span class="icones__label">
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exibeDadosGerenciamento<?=$key?>">Ver Detalhes</button>
                                                </span>
                                                <b>
                                                    Grupo: <span class="text-primary"><?=$cadaGerenciamento['nome_grupo']?></span>
                                                </b>
                                                <br>
                                                <b>
                                                    Categoria: <span class="text-primary"><?=$cadaGerenciamento['nome_categoria']?></span>
                                                </b>
                                            </p>


                                            <hr>
                                            
                                            <?php $dadosPessoaGerenciamento = $gerenciamento->listaPessoasDoServicosAgendamento($cadaGerenciamento['codigo_servico_agendamento']);?>

                                            <!-- Modal para exibir detalhes do gerenciamento-->
                                            <div class="modal fade" id="exibeDadosGerenciamento<?=$key?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content modal-dialog-scrollable">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><i class='bx bx-bookmark mr-2 text-primary'></i>   Detalhes do Gerenciamento</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="header text-primary">
                                                                <h4>
                                                                    Dados Gerais
                                                                </h4>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col">
                                                                    <label>Grupo</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaGerenciamento['nome_grupo']?>" disabled>
                                                                </div>

                                                                <div class="col">
                                                                    <label>Categoria</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaGerenciamento['nome_categoria']?>" disabled>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">

                                                                <div class="col">
                                                                    <label>Data de Criação</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaGerenciamento['data_criacao']?>" disabled>
                                                                </div>

                                                                <div class="col">
                                                                    <label>Data Última Atualização</label>
                                                                    <input type="text" class="form-control" value="<?=$cadaGerenciamento['data_atualizacao']?>" disabled>
                                                                </div>

                                                            </div>

                                                            <hr>

                                                            <div class="header text-primary">
                                                                <h4>
                                                                    Pessoas Vinculadas
                                                                </h4>
                                                            </div>

                                                            <?php if($dadosPessoaGerenciamento){?>

                                                                <?php foreach($dadosPessoaGerenciamento AS $cadaPessoa){?>

                                                                    <p>
                                                                        <b>
                                                                            <i class='bx bx-user text-primary' ></i>    -   <?=$cadaPessoa['nome_pessoa']?>
                                                                        </b>
                                                                    </p>

                                                                    <hr>

                                                                <?php }?>

                                                            <?php } else { ?>

                                                                <div class="pessoas__gerenciamento w-100 text-center">
                                                                    <p class="text-danger">
                                                                        <b>
                                                                            Não existem pessoas vinculadas !s
                                                                        </b>
                                                                    </p>
                                                                </div>

                                                            <?php }?>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fehar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            
                                            
                                        <?php }?>

                                    <?php }else{ ?>

                                    <?php } ?>
                                </div>
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

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

    <script src="../Public/js/agendamento_servico.js"></script>

</body>

</html>