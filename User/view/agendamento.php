<?php
include_once '../../Admin/src/functions.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../../Admin/src/" . $class . ".php");
});

// Iniciando a sessão ou verificando se o usuário possui a mesma.
verificaSessaoUsuario();

// Vamos retornar todas as consultas agendadas pelo usuário em questão
$consultas          = new PacienteConsulta();
$casu               = new Casu();

// if(isset($_GET['codigo_agendamento_busca']) && $_GET['codigo_agendamento_busca'] != NULL){
//     $consultasPaciente  = $consultas->retornaTodasConsultaDoPaciente($_SESSION['codigo_paciente'], $_GET['codigo_agendamento_busca']);
// }else{
//     $consultasPaciente  = $consultas->retornaTodasConsultaDoPaciente($_SESSION['codigo_paciente']);
// }

// Vamos retornar todas categorias ativas cadastradas
if( isset($_GET['codigo_agendamento_busca']) ){
    $categorias             = $consultas->retornaTodasCategorias($_SESSION['codigo_paciente'], $_GET['codigo_agendamento_busca']);
}else{
    $categorias             = $consultas->retornaTodasCategorias($_SESSION['codigo_paciente']);
}


if (isset($_GET['agendamento']) && $_GET['agendamento'] == "erro") {
    $exibeErroAgendamento   = true;
} else {
    $exibeErroAgendamento   = false;
}

if (isset($_GET['agendamento']) && $_GET['agendamento'] == "sucesso") {
    $exibeSucessoAgendamento   = true;
} else {
    $exibeSucessoAgendamento   = false;
}

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

    <title>Hospital Irmã Denise - Meus Agendamentos</title>
</head>

<body class="bg-light" onclick="removeListaAutoComplete();">

    <!-- INCLUINDO CABEÇALHO DO ARQUIVO -->
    <?php include_once('./header.php') ?>

    <div class="container px-4 py-5">

        <?php if($exibeSucessoAgendamento){?>
            <div class="alert alert-primary alert-dismissible fade show w-100 text-center" role="alert">
                <strong> Serviço solicitado com sucesso !</strong> Aguarde o deferimento do seu serviço.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }?>

        <span class="btn btn-primary btn-sm rounded-5">
            <a href="./consulta.php" class="text-light remove_decoracao_link"><i class="bi bi-arrow-left-circle"></i> Voltar</a>
        </span>

        <div class="text-center">
            <h2 class="pb-2 text-secondary"><i class="bi bi-check2-circle"></i>   Meus agendamentos</h2>
        </div>

        <?php if($categorias){?>

            <?php foreach($categorias AS $keyCategoria => $cadaCategoria){?>

                <h4 class="pb-2 border-bottom"><i class="bi bi-caret-right"></i> <?=$cadaCategoria['nome_categoria']  ."-".   $cadaCategoria['nome_sub_categoria']?></h4>

                <!-- Vamos buscar todas as consultas do paciente por sua determinada categoria -->
                <?php if(isset($_GET['codigo_agendamento_busca'])){?>
                    <?php $consultaPacienteCategoria    = $consultas->retornaConsultaDoPacientePorCategoria($_SESSION['codigo_paciente'], $_GET['codigo_agendamento_busca'], $cadaCategoria['codigo_categoria'], $cadaCategoria['codigo_sub_categoria'])?>
                <?php } else {?>
                    <?php $consultaPacienteCategoria    = $consultas->retornaConsultaDoPacientePorCategoria($_SESSION['codigo_paciente'], NULL, $cadaCategoria['codigo_categoria'], $cadaCategoria['codigo_sub_categoria'])?>
                <?php }?>

                
                <?php if($consultaPacienteCategoria){?>

                    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">

                        <?php foreach($consultaPacienteCategoria AS $cadaConsulta){?>

                            <div class="col d-flex align-items-start card_marcacao">

                                <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">

                                    <i class="bi bi-clipboard-heart text-primary tamanho_icone"></i>

                                </div>

                                <div>

                                    <h5 class="text-secondary"><?=$cadaConsulta['nome_agendamento']?></h5>

                                    <p><b><i class="bi bi-stopwatch"></i>   Hora:</b> <?=$cadaConsulta['hora_agendamento']?></p>

                                    <p><b><i class="bi bi-calendar-check"></i>  Data:</b> <?=$cadaConsulta['data_agendamento']?></p>

                                    <p><b><i class="bi bi-cash"></i>  Valor:</b> R$ <?=$cadaConsulta['valor_agendamento']?></p>

                                    <p><b><i class="bi bi-signpost-split"></i>  Local:</b>  <?=$cadaConsulta['local_agendamento']?></p>


                                    <?php if($cadaConsulta['status'] == "deferido"){?>

                                        <a href="../Paciente/comprovante.php?codigo_agendamento=<?=$cadaConsulta['codigo_agendamento']?>" class="btn btn-primary" target="_black">
                                            Comprovante de marcação
                                        </a>

                                    <?php }else if($cadaConsulta['status'] == "indeferido"){?>

                                        <a class="btn btn-danger" disabled="disabled">
                                            Indeferido
                                        </a>

                                    <?php }else {?>

                                        <a class="btn btn-secondary" disabled="disabled">
                                            Em análise
                                        </a>

                                    <?php }?>

                                </div>

                            </div>

                        <?php }?>

                    </div>

                <?php } ?>

            <?php }?>

        <?php } else { ?>

            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Não encontramos nenhuma categoria criada !</h4>
                <p>
                    Aguarde até que sua respectiva categoria de <b>marcação</b> seja criada pela equipe da <?=$casu->nomeEmpresa?>. Para mais informação entre em contato <a href="mailto: <?=$casu->emailEmpresa?>" class="text-danger">clicando aqui !</a> .
                </p>
                <hr>
                <p class="mb-0 text-center">
                    <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
                </p>
            </div>

        <?php }?>

        <!-- INCLUINDO RODAPÉ DO ARQUIVO -->
        <?php include_once('./footer.php') ?>

    </div>

    <!-- =====================   JS BOOSTRAP    ========================= -->
    <script src="../Public/js/bootstrap.bundle.min.js"></script>
    <script src="../Public/js/bootstrap.min.js"></script>

    <!-- =====================   JS JQUERY    ========================= -->
    <script src="../../Admin/Public/js/jquery.js"></script>

    <!-- =====================   JS JQUERY MASK   ========================= -->
    <script src="../../Admin/Public/js/jquery.mask.min.js"></script>

    <!-- =====================   JS DADOS PACIENTE    ========================= -->
    <script src="../Public/js/dados_paciente.js"></script>

</body>

</html>