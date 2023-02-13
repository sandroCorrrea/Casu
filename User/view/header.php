<?php

$paciente               = new Paciente();
$todosDadosDoPaciente   = $paciente->retornaTodosDadosDoPaciente($_SESSION['codigo_paciente']);
$todosDadosDoPaciente   = $todosDadosDoPaciente[0];
?>
<header class="py-3 mb-3 border-bottom" onclick="removeListaAutoComplete();">

    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">

        <div class="dropdown">

            <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

                <img src="../../Admin/Public/img/logo.png" alt="Logo" class="img__logo_login">

            </a>

            <ul class="dropdown-menu text-small shadow">

                <?php if ($_SERVER['SCRIPT_NAME'] == "/Casu/User/view/consulta.php") { ?>
                    <li>
                        <a class="dropdown-item active text-light" href="./consulta.php" aria-current="page"> <i class="bi bi-activity text-light"></i> Agendamentos</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-secondary" href="./agendamento.php"> <i class="bi bi-book text-primary"></i> Meus Agendamentos</a>
                    </li>
                <?php } else if ($_SERVER['SCRIPT_NAME'] == "/Casu/User/view/agendamento.php") { ?>
                    <li>
                        <a class="dropdown-item text-secondary" href="./consulta.php" aria-current="page"> <i class="bi bi-activity text-primary"></i> Agendamentos</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-secondary active text-light" href="./agendamento.php"> <i class="bi bi-book text-light"></i> Meus Agendamentos</a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a class="dropdown-item text-secondary" href="./consulta.php" aria-current="page"> <i class="bi bi-activity text-primary"></i> Agendamentos</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-secondary" href="./agendamento.php"> <i class="bi bi-book text-primary"></i> Meus Agendamentos</a>
                    </li>
                <?php } ?>

            </ul>

        </div>

        <div class="d-flex align-items-center">

            <form class="w-100 me-3" role="search">

                <input type="search" class="form-control" placeholder="Buscar Agendamento ..." onkeyup="verificaAgendamentoUsuario(this.value);">
                <span id="resultado_pesquisa"></span>

            </form>
            

            <div class="flex-shrink-0 dropdown">

                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

                    <img src="../../Admin/Public/img/undraw_profile.svg" alt="Foto Login" width="32" height="32" class="rounded-circle">

                </a>

                <ul class="dropdown-menu text-small shadow">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#dadosUsuario"><i class="bi bi-person-circle text-primary"></i> Meus Dados</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#sair"><i class="bi bi-box-arrow-left text-danger"></i> Sair</a></li>
                </ul>

                <!-- Modal para deslogar usuário-->
                <div class="modal fade" id="sair" tabindex="-1" aria-labelledby="deslogarUsuario" aria-hidden="true">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <div class="modal-header w-100">

                                <h1 class="modal-title fs-5 text-danger" id="deslogarUsuario"><i class="bi bi-exclamation-triangle"></i> Atenção !</h1>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>

                            <div class="modal-body text-center">

                                <b>
                                    <?= $_SESSION['nome'] ?> deseja realmente sair de sua conta ?
                                </b>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                <form action="../Paciente/logout.php" method="post">
                                    <input type="hidden" name="acao" value="deslogar">
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal para ver dados do usuário -->
                <div class="modal fade" id="dadosUsuario" tabindex="-1" aria-labelledby="dadosUsuarioLogado" aria-hidden="true">

                    <div class="modal-dialog modal-lg modal-dialog-scrollable">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h1 class="modal-title fs-5 text-primary" id="dadosUsuarioLogado"><i class="bi bi-person-circle mr-2"></i> Minhas Informações </h1>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>

                            <div class="modal-body">

                                <div class="row g-2">

                                    <div class="col-md">

                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="nome" placeholder=" " name="nome" value="<?= $todosDadosDoPaciente['nome_paciente'] ?>" disabled>
                                            <label for="nome">Nome</label>
                                        </div>

                                    </div>

                                </div>

                                <div class="row g-2 mt-2">

                                    <div class="col-md">

                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="emailPaciente" placeholder=" " name="emailPaciente" value="<?= $todosDadosDoPaciente['login_paciente'] ?>" disabled>
                                            <label for="emailPaciente">E-mail</label>
                                        </div>

                                    </div>

                                </div>

                                <div class="row g-2 mt-2">

                                    <div class="col-md">
                                        <div class="form-floating">

                                            <?php if ($todosDadosDoPaciente['telefone']) { ?>

                                                <input type="text" class="form-control" id="telefone" placeholder=" " name="telefone" value="<?= mask($todosDadosDoPaciente['telefone'], '(##)####-####') ?>" disabled>

                                            <?php } else { ?>

                                                <input type="text" class="form-control" id="telefone" placeholder=" " name="telefone" value="" disabled>

                                            <?php } ?>

                                            <label for="telefone">Telefone</label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="celular" placeholder=" " name="celular" value="<?= mask($todosDadosDoPaciente['celular'], '(##)######-####') ?>" disabled>
                                            <label for="celular">Celular</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row g-2 mt-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="dataNascimento" placeholder=" " name="dataNascimento" value="<?= $todosDadosDoPaciente['data_nascimento'] ?>" disabled>
                                            <label for="dataNascimento">Data de Nascimento</label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">

                                            <input type="text" class="form-control" id="cpf" placeholder=" " name="cpf" value="<?= mask($todosDadosDoPaciente['cpf_paciente'], '###.###.###-##') ?>" disabled>

                                            <label for="cpf">CPF</label>

                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">

                                            <input type="text" class="form-control" id="numeroIdentidade" placeholder=" " name="numeroIdentidade" value="<?= mask($todosDadosDoPaciente['numero_identidade'], '##.###.###') ?>" disabled>

                                            <label for="numeroIdentidade">Número de Identidade</label>

                                        </div>
                                    </div>

                                </div>

                                <div class="row g-2 mt-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="estadoIdentidade" placeholder=" " name="estadoIdentidade" value="<?= $todosDadosDoPaciente['uf_identidade'] ?>" disabled>
                                            <label for="estadoIdentidade">Estado Identidade</label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="orgaoExpeditor" placeholder=" " name="orgaoExpeditor" value="<?= $todosDadosDoPaciente['orgao_expeditor_identidade'] ?>" disabled>
                                            <label for="orgaoExpeditor">Orgão Expeditor</label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="cep" placeholder=" " name="cep" value="<?= mask($todosDadosDoPaciente['cep'], "#####-###") ?>" disabled>
                                            <label for="cep">CEP</label>
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <div class="form-check">

                                    <?php if ($_SESSION['not_promo'] == "sim") { ?>
                                        <input type="checkbox" class="form-check-input" id="receberNotificacoes" name="notificacoes_promocionais" checked disabled>
                                    <?php } else { ?>
                                        <input type="checkbox" class="form-check-input" id="receberNotificacoes" name="notificacoes_promocionais" disabled>
                                    <?php } ?>

                                    <label class="form-check-label" for="receberNotificacoes">Receber notificações promocionais</label>

                                </div>

                                <div class="form-check">

                                    <?php if ($_SESSION['not_consu'] == "sim") { ?>
                                        <input type="checkbox" class="form-check-input" id="receberAlarme" name="notificacao_consulta" checked disabled>
                                    <?php } else { ?>
                                        <input type="checkbox" class="form-check-input" id="receberAlarme" name="notificacao_consulta" disabled>
                                    <?php } ?>

                                    <label class="form-check-label" for="receberAlarme">Receber notificações referente ao prazo de suas consultas.</label>

                                </div>

                            </div>

                            <div class="modal-footer mb-3">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</header>
<!-- =====================   JS JQUERY    ========================= -->
<script src="../../Admin/Public/js/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script type="text/javascript">
    async function verificaAgendamentoUsuario(valor) {
        
        if (valor.length > 0) {

            const requisicao = await fetch(`../Paciente/lista_agendamento_paciente.php?nomeAgendamento=${valor}`);
            const resposta = await requisicao.json();

            var html = "<ul class='list-group position-fixed' id='lista_paginacao'>";

            if (resposta['erro']) {
                html += `<li class='list-group-item disabled text-danger'><i class="bi bi-exclamation-triangle mr-2"></i>    ${resposta.mensagem}</li>`;
            } else {

                for (i = 0; i < resposta['dados'].length; i++) {
                    html += `<a href="../view/agendamento.php?codigo_agendamento_busca=${resposta['dados'][i].codigo_agendamento}" class='text-decoration-none'><li class='list-group-item list-group-item-action text-primary'><i class="bi bi-bag-heart mr-2"></i>   ${resposta['dados'][i].nome_agendamento}   -   Data do agendamento: ${resposta['dados'][i].data_agendamento}</li></a>`;
                }

            }

            html += "<ul>";

            document.getElementById("resultado_pesquisa").innerHTML = html;
        }

    }

    var removeListaAutoComplete = () => {

        var lista = document.getElementById("lista_paginacao");

        if(lista){
            lista.outerHTML = "";
        }
    };

</script>