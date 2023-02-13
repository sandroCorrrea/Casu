<?php
include_once '../../Admin/src/functions.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../../Admin/src/" . $class . ".php");
});

// Iniciando a sessão ou verificando se o usuário possui a mesma.
verificaSessaoUsuario();

extract($_GET);

// Vamos buscar todos os agendamentos referentes a categoria selecionada.
$agendamento                = new Agendamento();
$servicoPaciente            = new PacienteConsulta();
$agendamentosPorCategoria   = $agendamento->retornaTodosAgendamentosPorCategoria($codigo_servico_categoria_tipo);

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

    <title>Hospital Irmã Denise - Serviços</title>
</head>

<body class="bg-light" onclick="removeListaAutoComplete();">

    <!-- INCLUINDO CABEÇALHO DO ARQUIVO -->
    <?php include_once('./header.php') ?>

    <div class="container px-4 py-5">

        <span class="btn btn-primary btn-sm rounded-5">
            <a href="./consulta.php" class="text-light remove_decoracao_link"><i class="bi bi-arrow-left-circle"></i> Voltar</a>
        </span>

        <div class="text-center">
            <h2 class="pb-2 border-bottom text-secondary"><i class="bi bi-check2-circle"></i> <?= $nome_categoria . " - " . $nome_sub_categoria ?></h2>
        </div>

        
        <?php if($agendamentosPorCategoria){?>

            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            
                <?php foreach($agendamentosPorCategoria AS $key => $cadaAgendamento){?>
    
                    <div class="col d-flex align-items-start card_marcacao">

                        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">

                            <i class="bi bi-clipboard-heart text-primary tamanho_icone"></i>

                        </div>

                        <div>

                            <h3 class="fs-2 text-secondary"><?=$cadaAgendamento['nome']?></h3>

                            <p><b><i class="bi bi-stopwatch"></i>   Hora:</b> <?=$cadaAgendamento['hora']?></p>

                            <p><b><i class="bi bi-calendar-check"></i>  Data:</b> <?=$cadaAgendamento['data_formatada']?></p>

                            <p><b><i class="bi bi-people"></i>  Vagas:</b>  <?=$cadaAgendamento['vagas']?></p>

                            <p><b><i class="bi bi-cash"></i>  Valor:</b>  R$ <?=$cadaAgendamento['valor']?></p>

                            <!-- Vamos verificar se o paciente já solicitou o agendamento -->
                            <?php $solicitacaoAgendamento = $servicoPaciente->verificaAgendamentoJaFeito($_SESSION['codigo_paciente'], $cadaAgendamento['codigo_agendamento']);?>

                            <?php if($solicitacaoAgendamento){?>

                                <?php if($cadaAgendamento['vagas'] < 1){?>

                                    <a href="#" class="btn btn-secondary" disabled>

                                        Esgotado
                                        
                                    </a>

                                <?php }else {?>

                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dadosConsulta<?=$cadaAgendamento['codigo_agendamento']?>">

                                        Solicitar marcação

                                    </a>

                                <?php }?>

                            <?php }else {?>
                                <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#dadosConsulta<?=$cadaAgendamento['codigo_agendamento']?>">
                                    Solicitado
                                </a>
                            <?php }?>

                        </div>

                    </div>


                    <!-- Modal para exibir todos os detalhes da consulta e possibilitar a marcação da mesma -->
                    <div class="modal fade" id="dadosConsulta<?=$cadaAgendamento['codigo_agendamento']?>" tabindex="-1" aria-labelledby="descricao" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-scrollable modal-lg">

                            <form action="../Paciente/recebe_dados_agendamento.php" method="post" id="formulario_login_<?=$cadaAgendamento['codigo_agendamento']?>">

                                <!-- Dados essenciais para criar um agendamento -->
                                <input type="hidden" name="acao" value="inserir">

                                <input type="hidden" name="codigo_paciente" value="<?=$_SESSION['codigo_paciente']?>">

                                <input type="hidden" name="codigo_agendamento" value="<?=$cadaAgendamento['codigo_agendamento']?>">
                                <!-- Finalizando envio de dados essenciais para criar um agendamento -->

                                <div class="modal-content">
    
                                    <div class="modal-header">

                                        <h1 class="modal-title fs-5 text-secondary" id="descricao"><i class="bi bi-clipboard-heart text-primary tamanho_icone"></i> Confira todos detalhes do serviço: (<i><?=$cadaAgendamento['nome']?></i>)</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
    
                                    <div class="modal-body">

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="text" class="form-control" placeholder=" " disabled value="<?=$cadaAgendamento['nome']?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-arrow-bar-right"></i>    Nome</label>

                                                </div>

                                            </div>

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="date" class="form-control" placeholder=" " disabled value="<?=$cadaAgendamento['data']?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-calendar-check"></i> Data</label>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="time" class="form-control" placeholder=" " disabled value="<?=$cadaAgendamento['hora']?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-alarm"></i>    Horário</label>

                                                </div>

                                            </div>

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="number" class="form-control" placeholder=" " disabled value="<?=$cadaAgendamento['vagas']?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-people"></i>   Vagas disponíveis</label>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="text" class="form-control" placeholder=" " disabled value="<?=$nome_categoria?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-bookmark-check"></i>    Categoria</label>

                                                </div>

                                            </div>

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="text" class="form-control" placeholder=" " disabled value="<?=$nome_sub_categoria?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-tags"></i>   Tipo categoria</label>

                                                </div>

                                            </div>

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <input type="text" class="form-control" placeholder=" " disabled value="R$ <?=$cadaAgendamento['valor']?>">
                                                    <label class="text-dark label_fonte"><i class="bi bi-cash"></i>   Valor</label>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row g-2">

                                            <div class="col-md">
                                                
                                                <div class="form-floating">

                                                    <textarea class="form-control" disabled><?=$cadaAgendamento['local']?></textarea>
                                                    <label class="text-dark label_fonte"><i class="bi bi-signpost-split"></i>    Local do atendimento</label>

                                                </div>

                                            </div>

                                        </div>

                                        <hr>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">

                                                <div class="form-check">

                                                    <input class="form-check-input" name="checkbox_termo[<?=$key?>]" type="checkbox" id="checkboxConfirmacao<?=$key?>" checked>
                                                    
                                                    <label class="form-check-label" for="checkboxConfirmacao<?=$key?>">
                                                        <b class="termo_<?=$key?>">Confirmo que estou de acordo com todos os dados informados acima para o agendamento do serviço (<i><?=$cadaAgendamento['nome']?></i>).</b>
                                                    </label>
                                                    
                                                </div>

                                            </div>

                                        </div>
                                        
                                    </div>
    
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                                        <?php if($solicitacaoAgendamento){?>

                                            <!-- Tevemos sempre antes de submitar o formulário verificar se o mesmo estará marcado -->
                                            <button type="button" class="btn btn-primary" onclick="verificaCheckboxMarcado('checkbox_termo[<?=$key?>]', 'checkboxConfirmacao<?=$key?>', 'termo_<?=$key?>', 'formulario_login_<?=$cadaAgendamento['codigo_agendamento']?>');">Confirmar marcação</button>

                                        <?php } ?>

                                    </div>
    
                                </div>

                            </form>

                        </div>

                    </div>
    
                <?php }?>

            </div>

        <?php } else {?>
            <div class="alert alert-danger text-center" role="alert">

                <h4 class="alert-heading">Nenhum agendamento encontrado.</h4>

                <p>
                    <i class="bi bi-exclamation-circle tamanho_icone"></i>
                </p>

                <p>
                    Não encontramos nenhum agendamento encontrado na categoria informada <i>('<?=$nome_categoria . " - " . $nome_sub_categoria?>')</i>.
                </p>

                <hr>

                <p class="mb-0">Volte para verificiar as outras opções de marcação !</p>

            </div>
        <?php }?>

    </div>

    <?php include_once('./footer.php') ?>

</body>

<!-- JS PARA TRATAR MARCAÇÃO DE CONSULTAS -->
<script src="../Public/js/marcacao_consulta.js"></script>

</html>