<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    $categoriasAgendamento  = new ServicoCategoria();
    $agendamento            = new Agendamento();
    $itemCategoria          = new ServicoCategoriaTipo();

    $todasCategorias        = $categoriasAgendamento->listaTodasCategorias();
    $todosAgendamentos      = $agendamento->todosAgendamentos();

    // Vamos retornar todos os tipose de categoria.
    $todosTiposCategoria    = $itemCategoria->listaTodosTiposCategoria();

    if(isset($_GET['inserido']) && $_GET['inserido'] == "sucesso"){
        $mensagemInserido = true;
    }else{
        $mensagemInserido = false;
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

    <title>Hospital Irmã Denise - Agendamentos</title>
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

                <div class="container-fluid">

                    
                    <h1 class="h3 mb-2 text-gray-800">Cadastrar Agendamento</h1>
                    <p class="mb-4">
                        Crie um agendamento o mesmo irá aparecer diretamente para o paciente, preenche corretamento todas informações.
                    </p>

                    <div class="row">
                        <div class="card shadow mb-4 col-lg-6">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Criar agendamento</h6>
                            </div>
    
                            <?php if($mensagemInserido){?>
                                <div class="header text-center mb-2">
                                    <p>
                                        <b class="text-success">
                                            Agendamento Criado om Sucesso !
                                        </b>
                                    </p>
                                </div>
                            <?php }?>
    
                            <form action="../Agendamentos/recebe_dados_agendamento.php" method="post" id="formulario_agendamento">
    
                                <input type="hidden" name="acao" value="inserir">
    
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
        
                                            <label for="responsavalAgendamento">Responsável:</label>
        
                                            <input type="text" class="form-control" id="responsavalAgendamento" value="<?=$_SESSION['nome']?>" disabled>
        
                                            <input type="hidden" name="codigo_responsavel" value="<?=$_SESSION['codigo_pessoa']?>">
        
                                        </div>
        
                                        <div class="col">
        
                                            <label for="categoriaAgendamento" class="label__categoria">Categoria do Agendamento:</label>
        
                                            <select name="categoria_agendamento" id="categoriaAgendamento" class="form-control">
                                                <?php if($todosTiposCategoria){ ?>
        
                                                    <option value="selecione"> -- SELECIONE -- </option>
        
                                                    <?php foreach($todosTiposCategoria AS $cadaTipoCategoria){?>
        
                                                        <option value="<?=$cadaTipoCategoria['codigo_servico_categoria_tipo']?>"><?= $cadaTipoCategoria['nome_categoria'] . " - ". $cadaTipoCategoria['nome']?></option>
        
                                                    <?php }?>
        
                                                <?php } else { ?>
        
                                                    <option value="selecione">Não encontramos nenhuma categoria cadastrada !</option>
        
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
        
                                    <div class="row mt-2">
                                        <div class="col">
        
                                            <label for="horarioAtendimento" class="label_horario">Horário do Atendimento:</label>
        
                                            <input type="time" class="form-control" id="horarioAtendimento" name="horario">
        
                                        </div>
        
                                        <div class="col">
        
                                            <label for="dataAgendamento" class="label_data_agendamento">Data para o agendamento:</label>
                                            <input type="date" id="dataAgendamento" name="data_agendamento" class="form-control">
                                            
                                        </div>
                                    </div>
        
                                    <div class="row mt-2">
                                        <div class="col">
                                            <label for="nomeAgendamento" class="nome_agendamento">Nome agendamento:</label>
        
                                            <input type="text" class="form-control" id="nomeAgendamento" name="nome_agendamento">
                                        </div>
                                        <div class="col">
                                            <label for="vagasAgendamento" class="label_vagas">Quantidade de vagas:</label>
        
                                            <input type="number" class="form-control" id="vagasAgendamento" name="vagas_agendamento" onkeypress="return apenasNumeros();">
                                        </div>
                                    </div>

                                    <div class="row mt-2">

                                        <div class="col">
                                            <label for="valor" class="label_valor">Valor:</label>
        
                                            <input type="text" class="form-control" id="valor" name="valor">
                                        </div>

                                    </div>
        
                                    <div class="row mt-2">
                                        <div class="col">
                                            <label for="localAtendimento" class="label_local_atendimento">Descrição do local de atendimento:</label>
                                            <textarea name="localAtendimento" id="localAtendimento" class="form-control"></textarea>
                                        </div>
                                    </div>
        
                                </div>
    
                                <div class="botao_agendamento w-100 text-center mb-3">
                                    <button class="btn btn-facebook" type="button" id="botao_cria_agendamento">
                                        Criar Agendamento
                                    </button>
                                </div>
    
                            </form>
                            
                            <div class="text-center mb-4">
                                <a href="../view/servico_agendamento.php">Clique aqui para ver todos os agendamento !</a>
                            </div>
    
                        </div>

                        <div class="card shadow mb-4 col-lg-6 barra_rolagem">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Listagem de agendamentos cadastrados:</h6>
                            </div>

                            <div class="card-body">
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Hora</th>
                                            <th>Data</th>
                                            <th>Categoria</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($todosAgendamentos){ ?>

                                            <?php foreach($todosAgendamentos AS $cadaAgendamento){?>

                                                <?php if($cadaAgendamento['status'] == 'ativa') {?>
                                                    <tr class="text-primary fonte_agendamento">
                                                        <td><?=$cadaAgendamento['nome_agendamento']?></td>
                                                        <td><?=$cadaAgendamento['hora']?></td>
                                                        <td><?=$cadaAgendamento['data_formatada']?></td>
                                                        <td><?=$cadaAgendamento['nome_categoria'] ." - ".$cadaAgendamento['sub_categoria']?></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr class="text-danger fonte_agendamento">
                                                        <td><?=$cadaAgendamento['nome_agendamento']?></td>
                                                        <td><?=$cadaAgendamento['hora']?></td>
                                                        <td><?=$cadaAgendamento['data_formatada']?></td>
                                                        <td><?=$cadaAgendamento['nome_categoria']?></td>
                                                    </tr>
                                                <?php }?>


                                            <?php }?>

                                        <?php }else{ ?>
                                            <tr class="text-center">
                                                <td colspan="4" class="text-danger">Não possui nenhum agendamento marcado !</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>

            </div>

            <!-- Footer -->
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

    <script src='http://momentjs.com/downloads/moment.min.js'></script>

    <script src="../vendor/jquery/jquery.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

    <script src="../Public/js/maskMoney.js"></script>

    <script src="../Public/js/agendamento.js"></script>

</body>

</html>