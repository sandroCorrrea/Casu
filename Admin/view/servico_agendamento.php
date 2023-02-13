<?php
include_once '../src/functions.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../src/" . $class . ".php");
});

// Iniciando a sessão ou verificando se o usuário possui a mesma.
verificaSessaoUsuario();

// Listagem de todos Agendamentos
$agendamentos           = new Agendamento();
$todosAgendamentos      = $agendamentos->todosAgendamentos();

// Listagem de todas Categorias
$categoriasAgendamento  = new ServicoCategoria();
$subCategoria           = new ServicoCategoriaTipo();

$todasCategorias        = $categoriasAgendamento->listaTodasCategorias();

// Listagem de todas sub categorias
$todasSubCategorias     = $subCategoria->listaTodosTiposCategoria();

if (isset($_GET['alterado']) && $_GET['alterado'] == "sucesso") {
    $mensagemAlterado = true;
} else {
    $mensagemAlterado = false;
}

if (isset($_GET['excluido']) && $_GET['excluido'] == "sucesso") {
    $mensagemExcluido = true;
} else {
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

    <title>Hospital Irmã Denise - Serviços Agendamentos</title>
</head>

<body id="page-top" onclick="removeListaAutoComplete();">

    <div id="wrapper">

        <!--===INCLUINDO SIDEBAR PADRÃO==-->
        <?php include '../view/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!--===INCLUINDO NAVBAR PADRÃO==-->
                <?php include '../view/navbar.php' ?>

                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800">Agendamentos Realizados</h1>

                    <p class="mb-4">
                        Abaixo estão listados todos os agendamentos feitos pelos pacientes, com seus respectivos dados.
                    </p>

                    <?php if ($mensagemAlterado) { ?>
                        <div class="text-center text-success">
                            <p>
                                <b>
                                    Agendamento Alterado com Sucesso !
                                </b>
                            </p>
                        </div>
                    <?php } ?>

                    <?php if ($mensagemExcluido) { ?>
                        <div class="text-center text-success">
                            <p>
                                <b>
                                    Agendamento Excluído com Sucesso !
                                </b>
                            </p>
                        </div>
                    <?php } ?>

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary">Agendamentos</h6>

                            <hr>

                            <span>
                                <a class="btn btn-primary btn-sm" href="../view/agendamento.php">
                                    Cadastrar Agendamento
                                </a>
                            </span>

                        </div>

                        <div class="card-body">

                            <?php if ($todosAgendamentos) { ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-primary">
                                                <th>Nome do Agendamento</th>
                                                <th>Tipo</th>
                                                <th>Data e Hora</th>
                                                <th class="text-center">Alteração</th>
                                                <th class="text-center">Exclusão</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php foreach ($todosAgendamentos as $key => $cadaAgendamento) { ?>


                                                <?php if (isset($_GET['codigo_agendamento_busca']) && $_GET['codigo_agendamento_busca'] == $cadaAgendamento['codigo_agendamento']) { ?>

                                                    <?php if ($cadaAgendamento['status'] == "inativa") { ?>

                                                        <tr class="text-light bg-primary">
                                                            <th class="text-danger"><?= $cadaAgendamento['nome_agendamento'] ?></th>
                                                            <th class="text-danger"><?= $cadaAgendamento['nome_categoria'] . " - " . $cadaAgendamento['sub_categoria'] ?></th>
                                                            <th class="text-danger"><?= $cadaAgendamento['horario_consulta'] ?></th>
                                                            <th class="text-center" data-toggle="modal" data-target="#editarInformacoes<?= $key ?>">
                                                                <button class="btn btn-light text-primary btn-sm">
                                                                    Editar
                                                                </button>
                                                            </th>
                                                            <th class="text-center" data-toggle="modal" data-target="#excluirAgendamento<?= $key ?>">
                                                                <button class="btn btn-secondary btn-sm">
                                                                    Excluir
                                                                </button>
                                                            </th>
                                                        </tr>

                                                    <?php } else { ?>

                                                        <tr class="text-light bg-primary">
                                                            <th><?= $cadaAgendamento['nome_agendamento'] ?></th>
                                                            <th><?= $cadaAgendamento['nome_categoria'] . " - " . $cadaAgendamento['sub_categoria'] ?></th>
                                                            <th><?= $cadaAgendamento['horario_consulta'] ?></th>
                                                            <th class="text-center" data-toggle="modal" data-target="#editarInformacoes<?= $key ?>">
                                                                <button class="btn btn-light text-primary btn-sm">
                                                                    Editar
                                                                </button>
                                                            </th>
                                                            <th class="text-center" data-toggle="modal" data-target="#excluirAgendamento<?= $key ?>">
                                                                <button class="btn btn-secondary btn-sm">
                                                                    Excluir
                                                                </button>
                                                            </th>
                                                        </tr>

                                                    <?php } ?>

                                                <?php } else { ?>

                                                    <?php if ($cadaAgendamento['status'] == "inativa") { ?>

                                                        <tr>
                                                            <th class="text-danger"><?= $cadaAgendamento['nome_agendamento'] ?></th>
                                                            <th class="text-danger"><?= $cadaAgendamento['nome_categoria'] . " - " . $cadaAgendamento['sub_categoria'] ?></th>
                                                            <th class="text-danger"><?= $cadaAgendamento['horario_consulta'] ?></th>
                                                            <th class="text-center" data-toggle="modal" data-target="#editarInformacoes<?= $key ?>">
                                                                <button class="btn btn-primary btn-sm">
                                                                    Editar
                                                                </button>
                                                            </th>
                                                            <th class="text-center" data-toggle="modal" data-target="#excluirAgendamento<?= $key ?>">
                                                                <button class="btn btn-secondary btn-sm">
                                                                    Excluir
                                                                </button>
                                                            </th>
                                                        </tr>

                                                    <?php } else { ?>

                                                        <tr>
                                                            <th><?= $cadaAgendamento['nome_agendamento'] ?></th>
                                                            <th><?= $cadaAgendamento['nome_categoria'] . " - " . $cadaAgendamento['sub_categoria'] ?></th>
                                                            <th><?= $cadaAgendamento['horario_consulta'] ?></th>
                                                            <th class="text-center" data-toggle="modal" data-target="#editarInformacoes<?= $key ?>">
                                                                <button class="btn btn-primary btn-sm">
                                                                    Editar
                                                                </button>
                                                            </th>
                                                            <th class="text-center" data-toggle="modal" data-target="#excluirAgendamento<?= $key ?>">
                                                                <button class="btn btn-secondary btn-sm">
                                                                    Excluir
                                                                </button>
                                                            </th>
                                                        </tr>

                                                    <?php } ?>

                                                <?php } ?>



                                                <!-- Modal para exluir agendamento -->
                                                <div class="modal fade" id="excluirAgendamento<?= $key ?>" tabindex="-1" aria-labelledby="excluirAgendamento" aria-hidden="true">
                                                    <div class="modal-dialog">

                                                        <form action="../Agendamentos/recebe_dados_agendamento.php" method="post">

                                                            <input type="hidden" name="acao" value="excluir">

                                                            <input type="hidden" name="codigo_agendamento" value="<?= $cadaAgendamento['codigo_agendamento'] ?>">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-danger" id="excluirAgendamento"><i class='bx bx-error-circle text-danger'></i> Exclusão:</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="w-100 text-center text-danger">
                                                                        <p>
                                                                            <b>
                                                                                Deseja Realmente excluir o agendamento:
                                                                                <br>
                                                                                -> <?= $cadaAgendamento['nome_agendamento'] ?>
                                                                            </b>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                    <button type="submit" class="btn btn-primary">Confirmar Exclusão</button>
                                                                </div>
                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>



                                                <!-- Modal para editar informações -->
                                                <div class="modal fade" id="editarInformacoes<?= $key ?>" tabindex="-1" aria-labelledby="modalEdicao" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalEdicao"><i class='bx bx-right-arrow-alt mr-2 text-primary'></i> Dados do Agendamento</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form action="../Agendamentos/recebe_dados_agendamento.php" method="post">

                                                                <input type="hidden" name="acao" value="editar">

                                                                <input type="hidden" name="codigo_agendamento" value="<?= $cadaAgendamento['codigo_agendamento'] ?>">

                                                                <input type="hidden" name="codigo_pessoa" value="<?= $cadaAgendamento['codigo_pessoa'] ?>">

                                                                <div class="modal-body">

                                                                    <div class="row">

                                                                        <div class="col">
                                                                            <label for="nome_agendamento">Nome do Agendamento: </label>
                                                                            <input type="text" class="form-control" name="nome_agendamento" value="<?= $cadaAgendamento['nome_agendamento'] ?>" required>
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="categoria_agendamento">Categoria do Agendamento</label>
                                                                            <select name="categoria" id="categoria_agendamento" class="form-control">
                                                                                <?php if ($todasSubCategorias) { ?>

                                                                                    <?php foreach ($todasSubCategorias as $cadaSubCategoria) { ?>

                                                                                        <?php if ($cadaSubCategoria['codigo_servico_categoria_tipo'] == $cadaAgendamento['codigo_sub_categoria']) { ?>

                                                                                            <option value="<?= $cadaSubCategoria['codigo_servico_categoria_tipo'] ?>" selected><?= $cadaSubCategoria['nome_categoria'] . " - " . $cadaSubCategoria['nome'] ?></option>

                                                                                        <?php } else { ?>

                                                                                            <option value="<?= $cadaSubCategoria['codigo_servico_categoria_tipo'] ?>"><?= $cadaSubCategoria['nome_categoria'] . " - " . $cadaSubCategoria['nome'] ?></option>
                                                                                        <?php } ?>

                                                                                    <?php } ?>

                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mt-2">

                                                                        <div class="col">
                                                                            <label for="data_agendamento">Data do Agendamento: </label>
                                                                            <input type="date" class="form-control" name="data" value="<?= $cadaAgendamento['data'] ?>" required>
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="hora">Hora do Agendamento</label>
                                                                            <input type="time" id="hora" name="hora" value="<?= $cadaAgendamento['hora'] ?>" class="form-control" required>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mt-2">

                                                                        <div class="col">
                                                                            <label for="responsavel">Responsável: </label>
                                                                            <input type="text" id="responsavel" class="form-control" value="<?= $cadaAgendamento['nome_pessoa'] ?>" disabled>
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="vagas">Vagas</label>
                                                                            <input type="number" id="vagas" name="vagas" value="<?= $cadaAgendamento['vagas'] ?>" class="form-control" onkeypress="return apenasNumeros();" required>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mt-2">

                                                                        <div class="col">
                                                                            <label for="valor">Valor: </label>
                                                                            <input type="text" id="valor" class="form-control valores_agendamento" value="<?= $cadaAgendamento['valor'] ?>" name="valor">
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mt-2">

                                                                        <div class="col">
                                                                            <label for="local">Local do atendimento: </label>
                                                                            <textarea name="local" id="local" class="form-control" required><?= $cadaAgendamento['local'] ?></textarea>
                                                                        </div>

                                                                    </div>



                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                            <?php } ?>

                                        </tbody>

                                    </table>
                                </div>

                            <?php } else { ?>

                                <div class="w-100 text-center">
                                    <p>
                                        <b class="text-danger">
                                            Não Encontramos nenhum agendamento !
                                        </b>
                                    </p>
                                </div>

                            <?php } ?>

                        </div>
                    </div>

                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Desenvolvido por: <b>Agenda Contabilidade</b>, <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once('../view/logout.php'); ?>

    <script src="../vendor/jquery/jquery.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>
    
    <script src="../Public/js/maskMoney.js"></script>

    <script src="../Public/js/agendamento.js"></script>

</body>

</html>