<?php

include_once '../../Admin/src/functions.php';

spl_autoload_register(function ($class) {
    require_once("../../Admin/src/" . $class . ".php");
});

extract($_GET);

// INSTÂNCIAS USADAS
$agendamento            = new Agendamento();
$casu                   = new Casu();
$paciente               = new Paciente();
$agendamentoPaciente    = new PacienteConsulta();

// VAMOS BUSCAR TODOS OS DADOS DO PROTOCOLO
$cnpj               = mask($casu->cnpjEmpresa, "##.###.###/####-##");

$dadosDoAgendamento = $agendamento->todosAgendamentos($codigo_agendamento);
$dadosDoAgendamento = $dadosDoAgendamento[0];

$dadosDoPaciente    = $paciente->retornaTodosDadosDoPaciente($codigo_paciente);
$dadosDoPaciente    = $dadosDoPaciente[0];

$dadosReserva       = $agendamentoPaciente->retornaConsultaDoPaciente($codigo_paciente, $codigo_agendamento);
$dadosReserva       = $dadosReserva[0];

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$casu->nomeLegivelEmpresa?></title>

    <!-- LINK IMAGEM CABEÇALHO DA PÁGINA -->
    <link rel="shortcut icon" href="../../Admin/Public/img/cropped-casufunec.webp" type="image/x-icon">

    <!-- LINK BOOSTRAP -->
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">

    <!-- LINK STYLE -->
    <link rel="stylesheet" type="text/css" href="../Public/css/style.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .align-items-center {
            display: flex;
            align-items: center;
        }
    </style>


</head>

<body>

    <main>
        <div class="container py-4">

            <header class="pb-3 mb-4 border-bottom text-center">

                <div class="row marcador align-items-center">

                    <div class="col">

                        <a href="#">

                            <img src="../../Admin/Public/img/logo.png" alt="Logo" width="50%">

                        </a>

                    </div>

                </div>

                <span class="fs-4 text-dark">Detalhamento do Agendamento:</span>

            </header>

            <div class=" mb-4 bg-light rounded-3">

                <div class="container-fluid py-5">

                    <h4><b>Nome do Agendamento:</b></h4>
                    <b><?=$dadosDoAgendamento['nome_agendamento']?></b> 

                    <p class="col-md-8 mt-5">
                        <b>Descrição do Agendamento: </b>
                        <hr>
                        <b>Responsável</b>: <?=$dadosDoAgendamento['nome_pessoa']?>
                        <br>
                        <b>Categoria</b>: <?=$dadosDoAgendamento['nome_categoria']?>
                        <br>
                        <b>Horário da Consulta</b>: <?=$dadosDoAgendamento['horario_consulta']?>
                        <br>
                        <b>Número de Vagas</b>: <?=$dadosDoAgendamento['vagas']?>
                        <br>
                        <b>Valor</b>: R$ <?= str_replace(".", ",", $dadosDoAgendamento['valor'])?>
                        <br>
                        <b>Local de Atendimento</b>: <?=$dadosDoAgendamento['local']?>
                        <br>
                    </p>

                    <!-- <div class="text-center">
                        <a class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#registraAssinatura">Assinar Recebimento</a>
                    </div> -->

                </div>

            </div>

            <div class="row align-items-md-stretch">
                <div class="col-md-6">
                    <div class="h-100 p-5 text-bg-dark rounded-3">
                        <h2>Detalhes do Remetente:</h2>

                        <p>
                            <b>Empresa: </b><?= $casu->nomeLegivelEmpresa ?>
                        </p>

                        <p>
                            <b>Cnpj: </b><?= $cnpj ?>
                        </p>

                        <p>
                            <b>Endereço: </b><?= $casu->ruaEmpresa ?>, <?= $casu->bairroEmpresa ?>
                        </p>

                        <p>
                            <b>Cidade: </b><?= $casu->cidadeEmpresa ?>
                        </p>

                        <p>
                            <b>Uf: </b><?= $casu->estadoEmpresa ?>
                        </p>

                        <p>
                            <b>Ano: </b><?= date('Y') ?>
                        </p>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="h-100 p-5 bg-light border rounded-3">
                        <h2>Detalhes do Paciente:</h2>
                        <p>
                            <b>Nome: </b><?=$dadosDoPaciente['nome_paciente']?>
                        </p>

                        <p>
                            <b>Cpf: </b><?= mask($dadosDoPaciente['cpf_paciente'], "###.###.###-##")?>
                        </p>

                        <p>
                            <b>Cep: </b><?= mask($dadosDoPaciente['cep'], "#####-###")?>
                        </p>

                        <p>
                            <b>Rua: </b><?=$dadosDoPaciente['logradouro']?>
                        </p>

                        <p>
                            <b>Bairro: </b><?=$dadosDoPaciente['bairro']?>
                        </p>

                        <p>
                            <b>Cidade: </b><?=$dadosDoPaciente['localidade']?>
                        </p>

                        <p>
                            <b>Data de Nascimento: </b><?=$dadosDoPaciente['data_nascimento_formatado']?>
                        </p>

                        <p>
                            <b>E-mail: </b><?=$dadosDoPaciente['login_paciente']?>
                        </p>

                        <p>
                            <b>Celular: </b><?= mask($dadosDoPaciente['celular'], "(##)#####-####")?>
                        </p>

                        <?php if($dadosDoPaciente['telefone']){?>
                            <p>
                                <b>Telefone: </b><?= mask($dadosDoPaciente['telefone'], "(##)####-####") ?>
                            </p>
                        <?php }else {?>
                            <p>
                                <b>Telefone: </b>
                            </p>
                        <?php }?>

                        <p>
                            <b>Número de Identidade: </b><?= mask($dadosDoPaciente['numero_identidade'], "##.###.###")?>
                        </p>

                        <p>
                            <b>UF da Identidade: </b><?= $dadosDoPaciente['uf_identidade']?>
                        </p>

                        <p>
                            <b>Orgão expeditor: </b><?= $dadosDoPaciente['orgao_expeditor_identidade']?>
                        </p>

                    </div>
                </div>
                <div class="col-md-12 mt-5 text-center">
                    <p>
                        <b>Agendamento Criado em: <?=$dadosDoAgendamento['data_criacao_agendamento']?></b>
                    </p>

                    <p>
                        <b>Reservado em: <?=$dadosReserva['data_criacao_agendamento_paciente']?></b>
                    </p>
                </div>
            </div>

            <footer class="pt-3 mt-4 text-muted border-top">
                <?= $casu->nomeLegivelEmpresa ?>&copy; <?= date('Y') ?>
            </footer>
        </div>
    </main>

    <!-- SCRIPT BOOSTRAP -->
    <script src="../Public/js/bootstrap.bundle.min.js"></script>
    <script src="../Public/js/bootstrap.min.js"></script>

    <!-- JQUERY -->
    <script src="../../Customer/Public/js/jquery.js"></script>

    <!-- JQUERY MASK -->
    <script src="../../Customer/Public/js/jquery.mask.min.js"></script>

    <!-- JS DA PÁGINA -->
    <script>
        //<-========================== VALIDADE CPF ======================================->
        var cpfValidade = (cpf) => {

            let val = cpf;

            if (val.length == 14) {
                var cpf = val.trim();

                cpf = cpf.replace(/\./g, '');
                cpf = cpf.replace('-', '');
                cpf = cpf.split('');

                var v1 = 0;
                var v2 = 0;
                var aux = false;

                for (var i = 1; cpf.length > i; i++) {
                    if (cpf[i - 1] != cpf[i]) {
                        aux = true;
                    }
                }

                if (aux == false) {
                    return false;
                }

                for (var i = 0, p = 10;
                    (cpf.length - 2) > i; i++, p--) {
                    v1 += cpf[i] * p;
                }

                v1 = ((v1 * 10) % 11);

                if (v1 == 10) {
                    v1 = 0;
                }

                if (v1 != cpf[9]) {
                    return false;
                }

                for (var i = 0, p = 11;
                    (cpf.length - 1) > i; i++, p--) {
                    v2 += cpf[i] * p;
                }

                v2 = ((v2 * 10) % 11);

                if (v2 == 10) {
                    v2 = 0;
                }

                if (v2 != cpf[10]) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        };

        $(document).ready(() => {
            $("#cpfUsuario").mask("000.000.000-00");

            $("#enviaDadosFormulario").click(() => {
                var cpf         = $("#cpfUsuario").val();
                var verificaCpf = cpfValidade(cpf);
                var erro        = 0;
                var nome        = $("input[name='nome_do_responsavel_recebimento']").val();

                if(!verificaCpf){
                    erro = 1;
                    $("#cpfUsuario").addClass("border border-danger");
                }else{
                    $("#cpfUsuario").removeClass("border border-danger");
                }

                if(!nome){
                    erro = 1;
                    $("input[name='nome_do_responsavel_recebimento']").addClass("border border-danger");
                }else{
                    $("input[name='nome_do_responsavel_recebimento']").removeClass("border border-danger");
                }

                if(erro == 0){
                    $("#formularioAssinatura").submit();
                }
            });

        });


    </script>


</body>

</html>