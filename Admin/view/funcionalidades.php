<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    $itemCategoria          = new ServicoCategoriaTipo();

    // Vamos retornar todos os tipose de categoria.
    $todosTiposCategoria    = $itemCategoria->listaTodosTiposCategoria();
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

    <title>Hospital Irmã Denise - Funcionalidades</title>
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

                    <h1 class="h3 mb-1 text-gray-800">Funcionalidades</h1>
                    <p class="mb-4">
                        Abaixo estão sendo listadas algumas funcionalidades do sistema, clique na funcionalidade que for do seu desejo para que seja redirecionado para à mesma!
                    </p>

                    <div class="row">

                        <div class="col-lg-6">

                            <div class="card position-relative">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Funcionalidades Referentes ao seu Usuário</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="../view/dados_pessoais.php">
                                            <code>.Minhas Informações</code>
                                        </a>
                                        <hr>
                                        <a href="../view/meu_grupo.php">
                                            <code>.Meu Grupo</code>
                                        </a>
                                    </div>
                                    <div class="small mb-1">Acesso do seu Grupo:</div>
                                    <nav class="navbar navbar-expand navbar-light bg-light mb-4">
                                        <a class="navbar-brand">
                                            <?=$_SESSION['nome_grupo']?>
                                        </a>
                                    </nav>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card position-relative">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Funcionalidades Gerais</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <?php if($_SESSION['nome_grupo']){?>
                                            <a href="../view/administradores.php">
                                                <code>.Administração do Sistema</code>
                                            </a>
                                            <hr>
                                            <a href="../view/administradores.php">
                                                <code>.Criação de Grupos</code>
                                            </a>
                                            <hr>
                                            <a href="../view/administradores.php">
                                                <code>.Cadastro De Colaborador</code>
                                            </a>
                                            <hr>
                                            <a href="../view/administradores.php">
                                                <code>.Listagem de Grupos</code>
                                            </a>
                                            
                                        <?php }?>
                                    </div>

                                    <div class="small mb-1">Relatórios Gerais:</div>

                                    <nav class="navbar navbar-expand navbar-light bg-light mb-4">

                                        <a class="navbar-brand">Relatórios do Sistema:</a>

                                        <ul class="navbar-nav ml-auto">

                                            <li class="nav-item dropdown">

                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Relatórios
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right animated--fade-in" aria-labelledby="navbarDropdown">
                                                    
                                                    <a class="dropdown-item" href="../Relatorios/grupos.php?pacientes=todos" target="_blank">Pacientes</a>

                                                    <a class="dropdown-item" href="../Relatorios/grupos.php?codigoGrupo=<?=$_SESSION['codigo_grupo']?>" target="_blank">Meu Grupo</a>

                                                    <!-- Ao clicar na opção abaixo vamos exibir um modal com todas as opções para gerar o relatório em questão -->
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalRelatorio">Marcações</a>

                                                    <div class="dropdown-divider"></div>

                                                    <a class="dropdown-item" href="../Relatorios/grupos.php?grupos=todos" target="_blank">Grupos</a>

                                                </div>

                                            </li>

                                        </ul>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalRelatorio" tabindex="-1" role="dialog" aria-labelledby="relatorio" aria-hidden="true">

                                            <div class="modal-dialog modal-lg" role="document">

                                                <div class="modal-content">

                                                    <div class="modal-header">

                                                        <h5 class="modal-title" id="relatorio">Selecione alguma das opções para gerar o relatório:</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                            <span aria-hidden="true">&times;</span>

                                                        </button>
                                                    </div>

                                                    <form action="../Relatorios/consultas_realizadas.php" method="post" target="_blank">

                                                        <input type="hidden" name="relatorio" value="filtro_post">

                                                        <div class="modal-body">
    
                                                            <span class="w-100 text-dark text-center">
                                                                <b>Observação:</b> Caso nenhuma informação seja preenchida o relatório irá buscar os dados de forma gobal, ou seja <u> <b>com todas as datas e todas categorias !</b></u>
                                                            </span> 
    
                                                            <hr>
    
                                                            <div class="row">
    
                                                                <div class="col">
    
                                                                    <label for="dataInicio" class="label_inicio text-primary">Selecione uma data de início:</label>
    
                                                                    <input type="date" class="form-control" placeholder=" " id="dataInicio" name="inicio">
    
                                                                </div>
    
                                                                <div class="col">
    
                                                                    <label for="dataFim" class="label_fim text-primary">Selecione uma data de fim:</label>
    
                                                                    <input type="date" class="form-control" placeholder=" " id="dataFim" name="fim">
    
                                                                </div>
    
                                                            </div>
    
                                                            <hr>
    
                                                            <div class="row">
    
                                                                <div class="col">
    
                                                                    <label for="categoria" class="label_categori text-primary">Selecione um tipo de categoria:</label>
    
                                                                    <select name="categoria" id="categoria" class="form-control">
    
                                                                        <?php if($todosTiposCategoria){ ?>
                
                                                                            <option value=""> -- SELECIONE -- </option>
    
                                                                            <?php foreach($todosTiposCategoria AS $cadaTipoCategoria){?>
    
                                                                                <option value="<?=$cadaTipoCategoria['codigo_servico_categoria_tipo']?>"><?= $cadaTipoCategoria['nome_categoria'] . " - ". $cadaTipoCategoria['nome']?></option>
    
                                                                            <?php }?>
    
                                                                        <?php } else { ?>
    
                                                                            <option value="">Não encontramos nenhuma categoria cadastrada !</option>
    
                                                                        <?php }?>
                                                    
                                                                    </select>
    
                                                                </div>
    
                                                            </div>
    
                                                        </div>
    
                                                        <div class="modal-footer">
                                                            
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    
                                                            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
    
                                                        </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    </nav>

                                    <p class="mb-0 small">

                                        <b>Notas</b>: Caso alguma funcionalidade disponível no sistema não esteja listada para você, porém está sendo listada para outra pessoa, verifique seu grupo em questão.

                                    </p>

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

</body>

</html>