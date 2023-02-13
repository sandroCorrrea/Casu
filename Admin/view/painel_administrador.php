<?php
    include_once '../src/functions.php';

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Retorna a quantidade de agendamentos feitos no mês
    $agendamentos               = new Agendamento();
    $agendamentosNoMes          = $agendamentos->retornaQuantidadeAgendamentoMes(date('m'));
    $agendamentosNoMes          = $agendamentosNoMes[0];

    // Retorna últimas categorias
    $categorias                 = new ServicoCategoria();
    $ultimasCategorias          = $categorias->listaCategoriasRecentes();

    // Quantidade de agendamentos finalizados
    $agendamentosFinalizados    = $agendamentos->retornaQuantidadeDeAgendamentosFinalizados();

    // Totaliza valores dos agendamentos
    $totalAgendamentos          = $agendamentos->somaTotalAgendamentos();
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

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            Painel Administrativo - Hospital Irmã Denise
                        </h1>
                        <a href="../Relatorios/consultas_realizadas.php?tipo=diario" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_blank">
                            <i class="fas fa-download fa-sm text-white-50"></i> 
                            <span class="ml-2">
                                Relatório Diário
                            </span>
                        </a>
                    </div>

                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Agendamentos (Mês)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php if($agendamentosNoMes){?>
                                                    <?=$agendamentosNoMes['quantidade']?>                                                
                                                <?php } else{?>
                                                    <b class="text-danger">Nenhum Agendamento</b>
                                                <?php }?>
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
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Valor Previsto (Agendamentos)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?=$totalAgendamentos['valor']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Agendamentos Finalizados
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$agendamentosFinalizados['finalizados']?></div>
                                                </div>

                                                <div class="col">

                                                    <div class="progress progress-sm mr-2">
                                                        
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?=$agendamentosFinalizados['finalizados']?>%" aria-valuenow="<?=$agendamentosFinalizados['finalizados']?>" aria-valuemin="0" aria-valuemax="<?=$agendamentosFinalizados['total']?>"></div>

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

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Mensagens Pendentes
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                        
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                                    <h6 class="m-0 font-weight-bold text-primary">Total de marcações feitas em <?=date('Y')?></h6>

                                    <div class="dropdown no-arrow">

                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>

                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">

                                            <div class="dropdown-header">Relatórios:</div>

                                                <a class="dropdown-item" href="#">Gráfico</a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item" href="#">Relatório de Agendamentos</a>
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="card-body">

                                    <div class="chart-area">

                                        <canvas id="myAreaChart"></canvas>

                                    </div>

                                </div>

                            </div>

                        </div>
                        
                        <div class="col-xl-4 col-lg-5">
                            
                            <div class="card shadow mb-4">
                                
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                                    <h6 class="m-0 font-weight-bold text-primary">Últimas Categorias Cadastradas</h6>

                                    <div class="dropdown no-arrow">

                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>

                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">

                                            <div class="dropdown-header">Relatórios:</div>
                                                <a class="dropdown-item" href="#">Gráfico</a>
                                                <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Categorias</a>

                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    
                                    <?php if($ultimasCategorias){?>

                                        <div class="chart-pie pt-4 pb-2">

                                            <canvas id="myPieChart"></canvas>

                                        </div>

                                        <div class="mt-4 text-center small">

                                            <?php foreach($ultimasCategorias AS $key => $cadaCategoria){?>

                                                <?php $corAleatoria = random_color();?>

                                                <input type="hidden" name="cor[<?=$key?>]" value="<?=$corAleatoria?>" class="cores_radios">

                                                <span class="mr-2">

                                                    <i class="fas fa-circle" style="color:<?=$corAleatoria?>;"></i> <?=$cadaCategoria['nome']?>

                                                </span>
                                                
                                            <?php }?>

                                        </div>

                                    <?php }else {?>

                                        <div class="w-100 text-center text-danger">
                                            <h4>Não encontramos nenhuma categoria cadastrada !</h4>
                                            <br>
                                            <i class='bx bx-x-circle' style="font-size: 2rem;"></i>
                                            <hr>
                                            <a href="../view/servico_categoria.php">Clique aqui para cadastrar</a>
                                        </div>
            
                                    <?php }?>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../Public/js/sb-admin-2.min.js"></script>

    <!-- Page Plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- ==== Incluindo Gráficos Demonstrativos  === -->
    <script src="../Public/js/chart-area-demo.js"></script>
    <script src="../Public/js/chart-pie-demo.js"></script>

</body>

</html>