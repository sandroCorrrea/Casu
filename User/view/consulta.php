<?php
include_once '../../Admin/src/functions.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../../Admin/src/" . $class . ".php");
});

// Iniciando a sessão ou verificando se o usuário possui a mesma.
verificaSessaoUsuario();

// Vamos retornar todas as consultas agendadas pelo usuário em questão
$categorias         = new ServicoCategoria();
$subCategoria       = new ServicoCategoriaTipo();
$casu               = new Casu();

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

    <link rel="shortcut icon" href="../../Admin/Public/img/cropped-casufunec.webp" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="../Public/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../Public/css/estilo_user.css">

    <link rel="stylesheet" type="text/css" href="../../css/bootstrap-icons.css">

    <title>Hospital Irmã Denise - Consultas</title>
</head>

<body class="bg-light" onclick="removeListaAutoComplete();">

    <!-- INCLUINDO CABEÇALHO DO ARQUIVO -->
    <?php include_once('./header.php') ?>

    <div class="container">

        <div class="p-4 p-md-5 rounded">

            <div class="col-md-6 px-0">

                <h1 class="display-4 text-secondary"><i class="bi bi-check2-circle"></i> Verifique os serviços disponíveis !</h1>

                <p class="lead my-3">

                    Verifique nossa lista de serviços e faça seu agendamento !

                </p>

                <p>

                    <a href="./agendamento.php" class="btn btn-primary"><i class="bi bi-book-half"></i> Ver meus agendamentos</a>

                </p>

            </div>

        </div>


        <div class="row mb-1">

            <header class="w-100 text-center mb-3">

                <h4 class="text-secondary"><i class="bi bi-arrow-90deg-right"></i> Listagem de Serviços Disponíveis</h4>

            </header>

            <!-- Vamos verifica se existe alguma categoria cadastrada -->
            <?php if($todasCategorias) {?>

                <?php foreach($todasCategorias AS $key => $cadaCategoria) { ?>

                    <!-- Vamos buscar as subcategorias -->
                    <?php $todasSubCategorias   = $subCategoria->retornaTodasSubCategoriasDeUmaCategoria($cadaCategoria['codigo_servico_categoria']);?>

                    <div class="col">

                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                            
                            <div class="col p-4 d-flex flex-column position-static">

                                <h3 class="mb-0"><i class="bi bi-bookmark-plus"></i>    <?=$cadaCategoria['nome']?></h3>

                                <?php if($todasSubCategorias){?>

                                    <?php foreach($todasSubCategorias AS $cadaSubCategoria){?>
    
                                        <a href="./listagem_servicos.php?codigo_servico_categoria_tipo=<?=$cadaSubCategoria['codigo_servico_categoria_tipo']?>&nome_categoria=<?=$cadaCategoria['nome']?>&nome_sub_categoria=<?=$cadaSubCategoria['nome']?>" class="btn btn-outline-primary mt-4 w-100"><i class="bi bi-bookmark-heart icones_flutuante"></i>   <?=$cadaSubCategoria['nome']?></a>
                                        
                                    <?php }?>

                                <?php } else {?>
                                    
                                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                        <b>Não encontramos configurações desse serviço !</b>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>


                                <?php }?>

                            </div>

                        </div>

                    </div>

                <?php }?>

            <?php } else {?>

                <div class="alert alert-danger" role="alert">

                    <h4 class="alert-heading text-center">Não encontramos nenhum serviço !</h4>

                    <p>
                        Entre em contato com a equipe do suporte clicando nesse <a href="mailto:<?=$casu->emailEmpresa?>" class="text-danger">LINK</a> e informe mais detalhes sobre a tela de erro !
                    </p>

                    <hr>

                    <p class="text-center mb-0">
                        <i class="bi bi-exclamation-triangle tamanho_icone"></i>
                    </p>

                </div>

            <?php }?>

        </div>



        <!-- <h2 class="pb-2 border-bottom text-secondary"><i class="bi bi-check2-circle"></i>   Confira todos os serviços disponíveis !</h2> -->

        <!-- <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
            <div class="col d-flex flex-column align-items-start gap-2">
                <h3><i class="bi bi-chevron-right"></i>    Selecione seu serviço:</h3>
                <p class="text-muted">
                    Ao selecionar seu serviço você sera redirecionado até os agendamentos com seus respectivos horários.
                </p>
                <a href="./agendamento.php" class="btn btn-primary"><i class="bi bi-book-half"></i> Ver meus agendamentos</a>
            </div>

            <div class="col">

                <div class="row row-cols-1 row-cols-sm-2 g-4">

                    <?php if ($todasCategorias) { ?>

                        <?php foreach ($todasCategorias as $key => $cadaCategoria) { ?>
                            
                            <?php $todasSubCategorias   = $subCategoria->retornaTodasSubCategoriasDeUmaCategoria($cadaCategoria['codigo_servico_categoria']); ?>

                            <div class="col d-flex flex-column gap-2 text-center card_categoria">

                                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-4 rounded-3">

                                    <i class="bi bi-bookmark-heart tamanho_icone"></i>

                                </div>

                                <h4 class="fw-semibold mb-0 text-secondary"><?= $cadaCategoria['nome'] ?></h4>

                                <?php if ($todasSubCategorias) { ?>

                                    <?php foreach ($todasSubCategorias as $cadaSubCategoria) { ?>

                                        <a href="./listagem_servicos.php?codigo_servico_categoria_tipo=<?= $cadaSubCategoria['codigo_servico_categoria_tipo'] ?>&nome_categoria=<?= $cadaCategoria['nome'] ?>&nome_sub_categoria=<?= $cadaSubCategoria['nome'] ?>" class="remove_decoracao_link text-primary link_hover">
                                            <b><i class="bi bi-arrow-right"></i>   <?= $cadaSubCategoria['nome'] ?></b>
                                        </a>


                                        <hr class="border border-top-primary">
                                    <?php } ?>

                                <?php } ?>


                            </div>

                        <?php } ?>


                    <?php } ?>


                </div>
                
            </div>

        </div> -->

        <!-- INCLUINDO RODAPÉ DO ARQUIVO -->
        <?php include_once('./footer.php') ?>

    </div>

</body>

</html>