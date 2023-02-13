<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });


    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    $grupo                  = new Grupo();
    $quantidadePessoasGrupo = $grupo->listaQuantidadeDePessoasNoGrupo($_SESSION['codigo_grupo']);
    $quantidadePessoasGrupo = $quantidadePessoasGrupo[0]['quantidade'];

    $dadosDoGrupo           = $grupo->retornaTodosDadosDoGrupo($_SESSION['codigo_grupo']);
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

    <title>Hospital Irmã Denise - Meu Grupo</title>
</head>

<body id="page-top" onclick="removeListaAutoComplete();">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!--===INCLUINDO SIDEBAR PADRÃO==-->
        <?php include '../view/sidebar.php';?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!--===INCLUINDO NAVBAR PADRÃO==-->
                <?php include '../view/navbar.php'?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Meu Grupo</h1>
                    </div>

                    <div class="row">

                        
                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">
                                        
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Grupo Atual: <?=date('m/Y')?>
                                            </div>
                                            
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?=$_SESSION['nome_grupo']?>
                                            </div>

                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-info shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Número de Pessoas no Grupo
                                            </div>

                                            <div class="row no-gutters align-items-center">

                                                <div class="col-auto">

                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?=$quantidadePessoasGrupo?>
                                                    </div>
                                                    
                                                </div>

                                                <div class="col">

                                                    <div class="progress progress-sm mr-2">

                                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?=$quantidadePessoasGrupo?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-auto">

                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-6">

                            <div class="card mb-4">

                                <div class="card-header">

                                    Detalhes do Grupo

                                </div>

                                <div class="card-body">

                                    <p>
                                        <b class="text-primary">Nome: </b> <?=$dadosDoGrupo[0]['nome']?>
                                    </p>

                                    <p>
                                        <b class="text-primary">Descrição: </b> <?=$dadosDoGrupo[0]['descricao']?>
                                    </p>

                                    <p>
                                        <b class="text-primary">Data da Criação: </b> <?=$dadosDoGrupo[0]['data_criacao_grupo']?>
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            
                            <div class="card shadow mb-4">
                                
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                                    <h6 class="m-0 font-weight-bold text-primary">Relatórios Referente ao Grupo</h6>

                                    <div class="dropdown no-arrow">

                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>

                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">

                                            <div class="dropdown-header">
                                                Opções
                                            </div>

                                            <a class="dropdown-item" href="../Relatorios/grupos.php?codigoGrupo=<?=$_SESSION['codigo_grupo']?>" target="_blank">Relatório do Grupo</a>

                                            <div class="dropdown-divider"></div>

                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    Clique nos três botões ao lado e veja todos relatórios que estão disponíveis para o seu grupo !

                                </div>

                            </div>

                            <div class="card shadow">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Usuários do Mesmo Grupo</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample">
                                    <div class="card-body">
                                        <?php foreach($dadosDoGrupo AS $cadaDado){?>
                                            <p>
                                                <b>
                                                    <?=$cadaDado['nome_pessoa'] ."    -    ".mask($cadaDado['cpf'], "###.###.###-##") ?>
                                                </b>
                                            </p>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Desenvolvido por: <b>Agenda Contabilidade</b>, <?=date('Y')?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once('../view/logout.php');?>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

</body>

</html>