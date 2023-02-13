<?php

    // Vamos buscar a quantidade de solicitações pendentes existem cadastradas no sistema.
    $servicoSolicitacao     = new Solicitacoes();
    $solicitacoesPendentes  = $servicoSolicitacao->listaQuantidadeSolicitacoesPendentes();

    if(is_array($solicitacoesPendentes)){
        $quantidade             = sizeof($solicitacoesPendentes);
    }else{
        $quantidade             = 0;
    }

    if($quantidade <= 0){
        $quantidade = 0;
    }else{
        $quantidade = $quantidade;
    }

?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" onclick="removeListaAutoComplete();">


    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

        <div class="input-group">

            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar Por Agendamentos ..." onkeyup="carregarAgendamento(this.value);">
            

            <div class="input-group-append">

                <button class="btn btn-primary" type="button">

                    <i class="fas fa-search fa-sm"></i>

                </button>

            </div>

        </div>
        <span id="resultado_pesquisa"></span>
    </form>


    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow d-sm-none">

            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-search fa-fw"></i>

            </a>


            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">

                <form class="form-inline mr-auto w-100 navbar-search">

                    <div class="input-group">

                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">

                        <div class="input-group-append">

                            <button class="btn btn-primary" type="button">

                                <i class="fas fa-search fa-sm"></i>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </li>

        <li class="nav-item dropdown no-arrow mx-1">

            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-bell fa-fw"></i>
                
                <?php if($quantidade != 0){?>
                    <span class="badge badge-danger badge-counter"><?=$quantidade?>+</span>
                <?php }else {?>
                    <span class="badge badge-danger badge-counter"><?=$quantidade?></span>
                <?php }?>


            </a>
            
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Solicitações pendentes
                </h6>

                <?php if($solicitacoesPendentes){?>

                    <?php foreach($solicitacoesPendentes AS $cadaSolicitacao){?>
                        <a class="dropdown-item d-flex align-items-center" href="./solicitacoes.php?codigo_solicitacao=<?=$cadaSolicitacao['codigo_paciente_consulta']?>">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">
                                    <b>Solicitado em <?=$cadaSolicitacao['data_solicitacao']?></b>
                                </div>
                                <span class="font-weight-bold"><?=$cadaSolicitacao['nome_paciente']?> solicitou um serviço de <i><?=$cadaSolicitacao['nome_agendamento']?></i></span>
                            </div>
                        </a>
                    <?php }?>

                <?php }else{?>

                    <a class="dropdown-item d-flex align-items-center">
                        <div class="mr-3">
                            <div class="icon-circle bg-danger">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                Não encontramos nenhum agendamento pendente !
                            </span>
                        </div>
                    </a>

                <?php }?>


                <a class="dropdown-item text-center small text-gray-500" href="./solicitacoes.php">Ver todas solicitações</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger badge-counter">0</span>
            </a>
            
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    mensagens pendentes de pacientes
                </h6>
                <a class="dropdown-item d-flex align-items-center">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">Teste</div>
                        <div class="small text-gray-500">Nome do paciente</div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500">TODAS  MENSAGENS</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!--============== CABEÇALHO USUÁRIO =============-->
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$_SESSION['nome_formatado']?></span>

                <img class="img-profile rounded-circle" src="../Public/img/undraw_profile.svg">

            </a>

            <!--============== MENU COM OS DADOS DO USUÁRIO =============-->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <b class="dropdown-item" href="#" disabled>

                    <i class='bx bx-group mr-2 text-gray-400'></i>    

                    <?=$_SESSION['nome_grupo']?>

                </b>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">

                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                    Sair

                </a>

            </div>

        </li>

    </ul>

</nav>
<script type="text/javascript">

    async function carregarAgendamento(valor){

        if(valor.length > 0){

            const requisicao    = await fetch(`../Servicos/lista_agendamento.php?nome=${valor}`);
            const resposta      = await requisicao.json();

            var html            = "<ul class='list-group position-fixed' id='lista_auto_complete'>";

            if(resposta['erro']){
                html += `<li class='list-group-item disabled text-danger'><i class='bx bx-x-circle mr-2'></i>    ${resposta.mensagem}</li>`;
            }else{
                
                for(i = 0; i < resposta['dados'].length; i++){
                    html += `<a href="../view/servico_agendamento.php?codigo_agendamento_busca=${resposta['dados'][i].codigo_agendamento}"><li class='list-group-item list-group-item-action text-primary'><i class='bx bx-search-alt-2 mr-2'></i>   ${resposta['dados'][i].nome}   -   Data do agendamento: ${resposta['dados'][i].data}</li></a>`;
                }

            }

            html += "<ul>";

            document.getElementById("resultado_pesquisa").innerHTML = html;
        }
    }

    var removeListaAutoComplete = () => {

        var lista = document.getElementById("lista_auto_complete");

        if(lista){
            lista.outerHTML = "";
        }
    };
    
</script>