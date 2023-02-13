<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    // Lista todas solicitações
    $solicitacao            = new Solicitacoes();
    $todasSolicitacoes      = $solicitacao->listaTodasSolicitacoes();

    if(isset($_GET['alteracao']) && $_GET['alteracao'] == "sucesso"){
        $mensagemAlterado = true;
    }else{
        $mensagemAlterado = false;
    }

    if(isset($_GET['excluido']) && $_GET['excluido'] == "sucesso"){
        $mensagemExcluido = true;
    }else{
        $mensagemExcluido = false;
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

    <title>Hospital Irmã Denise - Solicitações</title>
</head>

<body id="page-top" onclick="removeListaAutoComplete();">

    <!-- Page Wrapper -->
    <div id="wrapper">
        
        <!--===INCLUINDO SIDEBAR PADRÃO==-->
        <?php include '../view/sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!--===INCLUINDO NAVBAR PADRÃO==-->
                <?php include '../view/navbar.php'?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Solicitações de agendamento</h1>
                    <p class="mb-4">
                        Abaixo estão listados todos os agendamentos feitos pelos pacientes, com seus respectivos dados.
                    </p>

                    <?php if($mensagemAlterado) {?>
                        <div class="text-center text-success">
                            <p>
                                <b>
                                    Agendamentos atualizados com sucesso !
                                </b>
                            </p>
                        </div>
                    <?php }?>

                    <?php if($mensagemExcluido) {?>
                        <div class="text-center text-success">
                            <p>
                                <b>
                                    Agendamento Excluído com Sucesso !
                                </b>
                            </p>
                        </div>
                    <?php }?>

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary">
                                
                                Solicitações
                                <?php if($todasSolicitacoes){?>
                                    <span style="float: right;">
                                        <button class="btn btn-facebook" id="salvaAnteracoesSolicitacoes">Salvar Alterações</button>
                                    </span>
                                <?php }?>


                            </h6>


                        </div>

                        <div class="card-body">

                            <?php if($todasSolicitacoes){?>

                                <form action="../Solicitacoes/recebe_dados_solicitacoes.php" method="post" id="formulario_solicitacoes">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Nome do agendamento</th>
                                                    <th>Paciente</th>
                                                    <th>Categoria</th>
                                                    <th>Data da Solicitação</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
    
                                            <tbody>
    
                                                <?php foreach($todasSolicitacoes AS $key => $cadaSolicitacao){?>
    
                                                    <?php if(isset($_GET['codigo_solicitacao']) && $cadaSolicitacao['codigo'] == $_GET['codigo_solicitacao']){?>

                                                        <tr class="border border-primary bg-primary text-light">
                                                            <td><?=$cadaSolicitacao['nome_agendamento']?></td>
                                                            <td><?=$cadaSolicitacao['nome_paciente']?></td>
                                                            <td><?=$cadaSolicitacao['nome_categoria']?></td>
                                                            <td><?=$cadaSolicitacao['data_solicitacao']?></td>
        
                                                            <td>
                                                                <?php if($cadaSolicitacao['status'] == "analise"){?>
                                                                    <select name="status[<?=$cadaSolicitacao['codigo']?>]" class="form-control text-secondary">
                                                                        <option value="analise-<?=$cadaSolicitacao['codigo']?>" selected>Pendente</option>
                                                                        <option value="deferido-<?=$cadaSolicitacao['codigo']?>">Deferido</option>
                                                                        <option value="indeferido-<?=$cadaSolicitacao['codigo']?>">Indeferido</option>
                                                                    </select>
                                                                <?php }else if($cadaSolicitacao['status'] == "deferido"){?>
                                                                    <select name="status[<?=$cadaSolicitacao['codigo']?>]" class="form-control text-primary">
                                                                        <option value="analise-<?=$cadaSolicitacao['codigo']?>">Pendente</option>
                                                                        <option value="deferido-<?=$cadaSolicitacao['codigo']?>" selected>Deferido</option>
                                                                        <option value="indeferido-<?=$cadaSolicitacao['codigo']?>">Indeferido</option>
                                                                    </select>
                                                                <?php }else {?>
                                                                    <select name="status[<?=$cadaSolicitacao['codigo']?>]" class="form-control text-danger">
                                                                        <option value="analise-<?=$cadaSolicitacao['codigo']?>">Pendente</option>
                                                                        <option value="deferido-<?=$cadaSolicitacao['codigo']?>">Deferido</option>
                                                                        <option value="indeferido-<?=$cadaSolicitacao['codigo']?> " selected>Indeferido</option>
                                                                    </select>
                                                                <?php }?>
                                                            </td>
        
        
                                                        </tr>

                                                    <?php } else {?>

                                                        <tr class="border border-primary">
                                                            <td><?=$cadaSolicitacao['nome_agendamento']?></td>
                                                            <td><?=$cadaSolicitacao['nome_paciente']?></td>
                                                            <td><?=$cadaSolicitacao['nome_categoria']?></td>
                                                            <td><?=$cadaSolicitacao['data_solicitacao']?></td>
        
                                                            <td>
                                                                <?php if($cadaSolicitacao['status'] == "analise"){?>
                                                                    <select name="status[<?=$cadaSolicitacao['codigo']?>]" class="form-control text-secondary">
                                                                        <option value="analise-<?=$cadaSolicitacao['codigo']?>" selected>Pendente</option>
                                                                        <option value="deferido-<?=$cadaSolicitacao['codigo']?>">Deferido</option>
                                                                        <option value="indeferido-<?=$cadaSolicitacao['codigo']?>">Indeferido</option>
                                                                    </select>
                                                                <?php }else if($cadaSolicitacao['status'] == "deferido"){?>
                                                                    <select name="status[<?=$cadaSolicitacao['codigo']?>]" class="form-control text-primary">
                                                                        <option value="analise-<?=$cadaSolicitacao['codigo']?>">Pendente</option>
                                                                        <option value="deferido-<?=$cadaSolicitacao['codigo']?>" selected>Deferido</option>
                                                                        <option value="indeferido-<?=$cadaSolicitacao['codigo']?>">Indeferido</option>
                                                                    </select>
                                                                <?php }else {?>
                                                                    <select name="status[<?=$cadaSolicitacao['codigo']?>]" class="form-control text-danger">
                                                                        <option value="analise-<?=$cadaSolicitacao['codigo']?>">Pendente</option>
                                                                        <option value="deferido-<?=$cadaSolicitacao['codigo']?>">Deferido</option>
                                                                        <option value="indeferido-<?=$cadaSolicitacao['codigo']?> " selected>Indeferido</option>
                                                                    </select>
                                                                <?php }?>
                                                            </td>
        
        
                                                        </tr>

                                                    <?php }?>

                                                <?php }?>
    
                                            </tbody>
                                            
                                        </table>
                                    </div>

                                </form>


                            <?php } else { ?>

                                <div class="w-100 text-center">
                                    <p>
                                        <b class="text-danger">
                                            Não Encontramos nenhuma solicitação !
                                        </b>
                                    </p>
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

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

    <script src="../Public/js/solicitacoes.js"></script>

</body>

</html>