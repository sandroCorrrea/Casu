<?php

    // Listando todos os dados da empresa matrix
    $dadosMatriz            = listaTodosDadosDaMatriz();
    $dadosMatriz            = $dadosMatriz[0];
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./painel_administrador.php">

        <img src="../Public/img/logo.png" alt="Logo" class="img__logo">

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">

        <a class="nav-link" href="./painel_administrador.php">

            <i class="fas fa-fw fa-tachometer-alt"></i>

            <span>Painel Administrativo</span>

        </a>

    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Opções
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Minhas Informações</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Configurações:</h6>
                <a class="collapse-item" href="./dados_pessoais.php">Dados Pessoais</a>
                <a class="collapse-item" href="./meu_grupo.php">Meu Grupo</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Gerenciamento</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Configurações:</h6>

                <?php if($_SESSION['nome_grupo'] == "Administradores"){?>

                    <a class="collapse-item" href="./administradores.php">Administradores</a>
                    
                <?php }?>

                <a class="collapse-item" href="./clientes.php">Usuários (Pacientes)</a>

                <a class="collapse-item" href="./funcionalidades.php">Funcionalidades</a>

            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Serviços
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Serviços</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Configurações:</h6>
                <a class="collapse-item" href="./servico_categoria.php">Categorias</a>
                <a class="collapse-item" href="./servico_categoria_tipo.php">Tipos de Categorias</a>
                <a class="collapse-item" href="./servico_agendamento.php">Agendamentos</a>
                <!-- <a class="collapse-item" href="./servicos_gerenciamento_agendamento.php">Gerenciar Agendamentos</a> -->
            </div>
        </div>
    </li>

    
    <li class="nav-item">
        <a class="nav-link" href="./agendamento.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Criar Agendamento</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="./solicitacoes.php">
            <i class='bx bx-bell'></i>
            <span>Solicitações</span>
        </a>
    </li>
    
    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <div class="sidebar-card d-none d-lg-flex">

        <img class="sidebar-card-illustration mb-2" src="../Public/img/logo_recorte.png" alt="Logo Recorte">

        <p class="text-center mb-2">
            <b><?=$dadosMatriz['nome_legivel']?></b>
            Pensando no bem-estar de pacientes, colaboradores e da comunidade.
        </p>

        <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#exibeDadosDaEmpresa">
            Dados Empresa
        </a>
        
        <!-- Modal Para editar dados da Empresa -->
        <div class="modal fade" id="exibeDadosDaEmpresa" tabindex="-1" aria-labelledby="dadosEmpresa" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="../Empresa/recebe_dados_empresa.php" method="post">

                        <input type="hidden" name="url_retorno" value="<?=$_SERVER['REQUEST_URI']?>">

                        <input type="hidden" name="acao" value="editar">

                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="dadosEmpresa"><i class='bx bx-home'></i>   Dados Gerais da Empresa: </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="height: 70vh; overflow-y: auto;">

                            <div class="row">
                                <div class="col">
                                    <label for="nomeEmpresa" class="text-dark">Nome Empresa</label>
                                    <input type="text" id="nomeEmpresa" class="form-control" name="nome_empresa" value="<?=$dadosMatriz['nome']?>">
                                </div>
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="cnpj" class="text-dark">CNPJ</label>
                                    <input type="text" id="cnpj" class="form-control" name="cnpj" value="<?=mask($dadosMatriz['cnpj'], "##.###.###/####-##")?>">
                                </div>

                                <div class="col">
                                    <label for="emailEmpresa" class="text-dark">E-mail</label>
                                    <input type="text" id="emailEmpresa" class="form-control" name="email" value="<?=$dadosMatriz['email']?>">
                                </div>
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="cep" class="text-dark">CEP</label>
                                    <input type="text" id="cep" class="form-control" name="cep" value="<?=mask($dadosMatriz['cep'], "#####-###")?>">
                                </div>

                                <div class="col">
                                    <label for="ruaEmpresa" class="text-dark">Rua</label>
                                    <input type="text" id="ruaEmpresa" class="form-control" name="rua" value="<?=$dadosMatriz['rua']?>">
                                </div>
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="bairro" class="text-dark">Bairro</label>
                                    <input type="text" id="bairro" class="form-control" name="bairro" value="<?=$dadosMatriz['bairro']?>">
                                </div>

                                <div class="col">
                                    <label for="cidade" class="text-dark">Cidade</label>
                                    <input type="text" id="cidade" class="form-control" name="cidade" value="<?=$dadosMatriz['cidade']?>">
                                </div>

                                <div class="col">
                                    <label for="uf" class="text-dark">UF</label>
                                    <input type="text" id="uf" class="form-control" name="uf" value="<?=$dadosMatriz['uf']?>">
                                </div>

                                <div class="col">
                                    <label for="numero" class="text-dark">Número</label>
                                    <input type="text" id="numero" class="form-control" name="numero" value="<?=$dadosMatriz['numero']?>">
                                </div>

                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="telefone" class="text-dark">Telefone</label>
                                    <?php if($dadosMatriz['telefone']){?>
                                        <input type="text" id="telefone" class="form-control" name="telefone" value="<?= mask($dadosMatriz['telefone'], "(##)####-####")?>">
                                    <?php }else{?>
                                        <input type="text" id="telefone" class="form-control" name="telefone">
                                    <?php }?>
                                </div>

                                <div class="col">
                                    <label for="celular" class="text-dark">Celular</label>
                                    <?php if($dadosMatriz['celular_empresa']){?>
                                        <input type="text" id="celular" class="form-control" name="celular" value="<?=mask($dadosMatriz['celular_empresa'], "(##)#####-####")?>">
                                    <?php }else{?>
                                        <input type="text" id="celular" class="form-control" name="celular">
                                    <?php }?>
                                    
                                </div>
                                
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="inscricao_estadual" class="text-dark">Inscrição Estadual</label>
                                    <input type="text" id="inscricao_estadual" class="form-control" name="inscricao_estadual" value="<?= $dadosMatriz['inscricao_estadual']?>">
                                </div>

                                <div class="col">
                                    <label for="tipo" class="text-dark">Tipo</label>
                                    <input type="text" id="tipo" class="form-control" name="tipo" value="<?= $dadosMatriz['tipo']?>">
                                </div>
                                
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="data_situacao_uf" class="text-dark">Data Situação UF</label>
                                    <input type="date" id="data_situacao_uf" class="form-control" name="data_situacao_uf" value="<?= $dadosMatriz['data_situacao_uf']?>">
                                </div>

                                <div class="col">
                                    <label for="situacao_cnpj" class="text-dark">Situação CNPJ</label>
                                    <input type="text" id="situacao_cnpj" class="form-control" name="situacao_cnpj" value="<?= $dadosMatriz['situacao_cnpj']?>">
                                </div>
                                
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="situacao_ie" class="text-dark">Situação IE</label>
                                    <input type="text" id="situacao_ie" class="form-control" name="situacao_ie" value="<?= $dadosMatriz['situacao_ie']?>">
                                </div>

                                <div class="col">
                                    <label for="cnae_empresa" class="text-dark">CNAE</label>
                                    <input type="text" id="cnae_empresa" class="form-control" name="cnae_empresa" value="<?= $dadosMatriz['cnae_empresa']?>">
                                </div>
                                
                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="nome_legivel" class="text-dark">Nome Fantasia:</label>
                                    <input type="text" id="nome_legivel" class="form-control" name="nome_legivel" value="<?= $dadosMatriz['nome_legivel']?>">
                                </div>
                                
                            </div>

                            
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" id="salva_dados_empresa">Salvar Alterações</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>


    </div>

</ul>