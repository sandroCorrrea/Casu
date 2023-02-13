<?php

include_once './Admin/src/functions.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("./Admin/src/" . $class . ".php");
});

$categorias         = new ServicoCategoria();
$subCategoria       = new ServicoCategoriaTipo();

$dadosEmpresa       = listaTodosDadosDaMatriz();
$dadosEmpresa       = $dadosEmpresa[0];

// Vamos listar todas categorias ATIVAS para os serviços
$todasCategorias    = $categorias->listaTodasCategorias();
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="./User/Public/img/cropped-casufunec.webp" type="image/x-icon">

    <title><?= $dadosEmpresa['nome_legivel']; ?></title>

    <link href="./css/style.css" rel="stylesheet" type="text/css">

    <link href="./User/Public/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="./css/bootstrap-icons.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="container py-3">

        <header>

            <div class="text-center">
                <img class="d-block mx-auto" src="./Admin/Public/img/logo.png" alt="" width="250" height="80">
            </div>

            <div class="d-flex flex-column flex-md-row align-items-center pb-1 border-bottom">
                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                    <a class="me-3 py-2 text-secondary text-decoration-none" href="#">Serviços</a>
                    <a href="./User/view/index.php" type="button" class="btn btn-outline-primary me-2">Login</a>
                    <a href="./cadastro.php" type="button" class="btn btn-primary">Cadastro</a>
                </nav>
            </div>

            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <span class="alinhar_opcao_esquerda span_voltar oculta_item">
                    <a href="./index.php" class="text-decoration-none btn-btn-primary">
                        <h5 class="text-primary"><i class="bi bi-arrow-left-circle"></i> Voltar</h5>
                    </a>
                </span>
                <h3 class="display-6 fw-normal" class="titulo_pagina">Serviços Disponíveis</h3>
            </div>
        </header>

        <div class="tabela_itens_servico oculta_item"></div>

        <main>

            <?php if ($todasCategorias) { ?>

                <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">

                    <?php foreach ($todasCategorias as $cadaCategoria) { ?>

                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-primary">
                                <div class="card-header py-3 text-bg-primary border-primary">
                                    <h4 class="my-0 fw-normal"><i class="bi bi-clipboard-heart mr-2"></i>    <?= $cadaCategoria['nome'] ?></h4>
                                </div>

                                <?php $subCategoriasFilha = $subCategoria->retornaTodasSubCategoriasDeUmaCategoria($cadaCategoria['codigo_servico_categoria']); ?>

                                <?php if ($subCategoriasFilha) { ?>
                                    <div class="card-body">
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <?php foreach ($subCategoriasFilha as $cadaSubCategoria) { ?>
                                                <li>
                                                    <a onclick="verificaCategoriaSelecionada('<?= $cadaSubCategoria['codigo_servico_categoria_tipo'] ?>', '<?= $cadaCategoria['nome'] . ' - ' . $cadaSubCategoria['nome'] ?>');" class="btn btn-outline-primary text-decoration-none w-100"><?= $cadaSubCategoria['nome'] ?></a>
                                                </li>
                                                <hr>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                    <?php } ?>

                </div>

            <?php } else { ?>
                <div class="alert alert-danger" role="alert">

                    <h4 class="alert-heading">Não foi encontrada nenhuma categoria !</h4>

                    <p>
                        Procuramos em nossos registros e não encontramos nenhuma categoria cadastrada, aguarde até que uma categoria seja criada.
                    </p>

                    <hr>

                    <p class="mb-0 text-center">
                        <i class="bi bi-exclamation-triangle tamanho_icone_padrao"></i>
                    </p>

                </div>
            <?php } ?>


        </main>

    </div>

    <!-- JAVASCRIPT FILES -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery.sticky.js"></script>
    <script src="./js/custom.js"></script>

</body>

</html>