<?php
    include_once './Admin/src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function ($class) {
        require_once("./Admin/src/" . $class . ".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    // verificaSessaoUsuario();
    
    $dadosEmpresa   = listaTodosDadosDaMatriz();
    $dadosEmpresa   = $dadosEmpresa[0];
    
    $categoria              = new ServicoCategoria();
    $todasCategorias        = $categoria->listaTodasCategorias();

    $quantidadeCategorias   = $categoria->quantidadeDeCategorias();
    $quantidadeCategorias   = $quantidadeCategorias[0];
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="./Admin/Public/img/cropped-casufunec.webp" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="./User/Public/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="./User/Public/css/estilo_user.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Hospital Irmã Denise - Cadastro</title>
</head>

<body class="bg-light">

    <div class="container">

        <main>

            <div class="py-5">

                <img class="d-block mx-auto mb-4 img__logo_cadastro" src="./Admin/Public/img/logo.png" alt="Logo">

                <div class="text-center">
                    <h2>Cadastre-se e veja nossos agendamentos !</h2>
                </div>

                <p class="lead">
                    Faça seu cadastro e veja todos os horários disponíveis para marcar sua consulta, sem precisar esperar em filas e no conforto de sua casa!
                </p>

                <p class="lead">
                    Preencha todas informações corretamento e veja sua caixa de e-mail.
                </p>

            </div>

            <div class="login_paciente w-100 mb-2 text-secondary">
                <a href="./User/view/index.php" class="link_login text-primary">
                    <i class='bx bx-left-arrow-circle text-primary'></i> Voltar para Login
                </a>
                <hr>
                <a href="./index.php" class="link_login text-primary">
                    <i class='bx bx-left-arrow-circle text-primary'></i> Voltar Página Principal
                </a>
            </div>

            <div class="row g-5">

                <div class="col-md-5 col-lg-4 order-md-last">

                    <h4 class="d-flex justify-content-between align-items-center mb-3">

                        <span class="text-primary">Tipos de Serviços Disponíveis</span>

                        <span class="badge bg-primary rounded-pill"><?=$quantidadeCategorias['quantidade']?></span>

                    </h4>

                    <ul class="list-group mb-3">

                        <?php if($todasCategorias){?>

                            <?php foreach($todasCategorias AS $cadaCategoria){?>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?=$cadaCategoria['nome']?></h6>
                                        <small class="text-muted">
                                            <?= utf8_encode($cadaCategoria['descricao']);?>
                                        </small>
                                    </div>
                                </li>
                            <?php }?>

                        <?php } else {?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div class="text-center">
                                    <h6 class="my-0 text-danger">Não Possuem Consultas Disponíveis</h6>
                                </div>
                            </li>
                        <?php }?>

                        
                    </ul>
                </div>


                <div class="col-md-7 col-lg-8">

                    <h4 class="mb-3">Dados Pessoais</h4>

                    <form class="needs-validation" method="post" id="formularioCadastroPaciente" action="./User/Paciente/recebe_dados_paciente.php">

                        <div class="row g-3">

                            <div class="col-sm-6">
                                <label for="primeiroNome" class="form-label label-nome">Nome</label>
                                <input type="text" class="form-control" id="primeiroNome" name="primeiroNomePaciente">
                            </div>

                            <div class="col-sm-6">
                                <label for="sobrenome" class="form-label label-sobrenome">Sobrenome</label>
                                <input type="text" id="sobrenome" class="form-control" name="sobrenome">
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label label-emailPaciente">E-mail</label>
                                <input type="email" class="form-control" id="email" name="emailPaciente">
                            </div>

                            <div class="col-sm-6">
                                <label for="telefonePaciente" class="form-label">Telefone</label> <span class="text-primary">(Opcional)</span>
                                <input type="text" class="form-control" id="telefonePaciente" name="telefone_paciente">
                            </div>

                            <div class="col-sm-6">
                                <label for="celular" class="form-label label-celular_paciente">Celular</label>
                                <input type="text" id="celular" class="form-control" name="celular_paciente">
                            </div>

                            <div class="col-md-4">
                                <label for="data_nascimento_paciente" class="form-label label-data_nascimento_paciente">Data de Nascimento</label>
                                <input type="date" id="data_nascimento_paciente" name="data_nascimento_paciente" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="cpf" class="form-label label-cpf">CPF</label>
                                <input type="text" id="cpf" name="cpf" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="numeroIdentidade" class="form-label label-numero_identidade">Número de Identidade</label>
                                <input type="text" id="numeroIdentidade" name="numero_identidade" class="form-control">    
                            </div>


                            <!-- SELETOR DE ESTADOS -->
                            <div class="col-md-5" id="seletor_estados_ibge"></div>

                            <div class="col-md-3">

                                <label for="orgaoExpeditor" class="form-label label-orgao_expeditor">Orgão Expeditor</label>

                                <input type="text" class="form-control" id="orgaoExpeditor" name="orgao_expeditor">
       
                            </div>

                            <div class="col-md-3">

                                <label for="cep_paciente" class="form-label label-cep">CEP</label>

                                <input type="text" class="form-control" id="cep_paciente" name="cep">
       
                            </div>


                        </div>

                        <hr class="my-4">

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="receberNotificacoes" name="notificacoes_promocionais" checked>

                            <label class="form-check-label" for="receberNotificacoes">Receber notificações promocionais</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="receberAlarme" name="notificacao_consulta" checked>

                            <label class="form-check-label" for="receberAlarme">Receber notificações referente ao prazo de suas consultas.</label>

                        </div>

                        <hr class="my-4">

                        <div class="botao_cadastro_paciente">
                            <button class="w-100 btn btn-primary btn-lg" type="button" id="botaoCadastroPaciente">Realizar Cadastro</button>
                        </div>

                        <div class="dados__endereco_cep"></div>

                    </form>

                </div>

            </div>

        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">

            <p class="mb-1">&copy; 2023 - <?=date('Y')?> Agenda Contabilidade</p>

        </footer>

    </div>

    <!-- =====================   JS BOOSTRAP    ========================= -->
    <script src="./User/Public/js/bootstrap.bundle.min.js"></script>
    <script src="./User/Public/js/bootstrap.min.js"></script>

    <!-- =====================   JS JQUERY    ========================= -->
    <script src="./Admin/Public/js/jquery.js"></script>

    <!-- =====================   JS JQUERY MASK   ========================= -->
    <script src="./Admin/Public/js/jquery.mask.min.js"></script>

    <!-- =====================   JS DADOS PACIENTE    ========================= -->
    <script src="./User/Public/js/dados_paciente.js"></script>

</body>

</html>