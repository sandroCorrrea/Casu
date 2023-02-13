<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    if(isset($_GET['sucesso']) && $_GET['sucesso'] == "grupo"){
        $mensagemGrupo = true;
    }else{
        $mensagemGrupo = false;
    }

    if(isset($_GET['user']) && $_GET['user'] == "sucesso"){
        $mensagemColaborador = true;
    }else{
        $mensagemColaborador = false;
    }

    if(isset($_GET['grupo']) && $_GET['grupo'] == "alterado"){
        $mensagemGrupoAlterado = true;
    }else{
        $mensagemGrupoAlterado = false;
    }

    $grupos         = new Grupo();
    $todosGrupos    = $grupos->retornaTodosGruposCadastrados();
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

    <title>Hospital Irmã Denise - Administradores</title>
</head>

<body id="page-top" onclick="removeListaAutoComplete();">

    <div id="wrapper">

        <!--===INCLUINDO SIDEBAR PADRÃO==-->
        <?php include '../view/sidebar.php';?>
        
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!--===INCLUINDO NAVBAR PADRÃO==-->
                <?php include '../view/navbar.php'?>

                <div class="container-fluid">

                    
                    <h1 class="h3 mb-1 text-gray-800">Gerenciamento de Administradores</h1>

                    <p class="mb-4">
                        Essa opção é disponível somente para usuários do grupo de <b class="text-primary">administradores</b>, sendo aqui possível cadastrar os usuários que irão acessar o sistema e criar grupos para os respectivos usuário.
                    </p>

                    <div class="row">

                        <div class="col-lg-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 mb-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Cadastrar Grupo:</h6>
                                </div>

                                <?php if($mensagemGrupo){?>

                                    <div class="text-center">
                                        <b class="text-success">
                                            Grupo Criado com Sucesso !
                                        </b>
                                    </div>

                                <?php }?>

                                <div class="card-body">

                                    <form action="../Grupos/recebe_dados_grupo.php" method="post" id="formularioGrupo">

                                        <input type="hidden" name="acao" value="inserirGrupo">

                                        <div class="mb-2">
                                            <label for="nomeGrupo" class="nomeGrupoLabel">Nome do Grupo</label>
                                            <input type="text" name="nomeGrupo" class="form-control text-primary">
                                        </div>
    
                                        <div class="mb-2">
                                            <label for="descricaoGrupo">Descrição do Grupo <span class="text-danger">(Opcional)</span></label>
                                            <textarea name="descricaoGrupo" id="descricaoGrupo" class="form-control text-primary"></textarea>
                                        </div>

                                        <div class="text-center mb-2">
                                            <button type="button" class="btn btn-facebook btn-sm" id="criarGrupoFormulario">Criar Grupo</button>
                                        </div>

                                    </form>

                                </div>
                            </div>

<!--                             
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Custom Font Size Utilities</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-xs">.text-xs</p>
                                    <p class="text-lg mb-0">.text-lg</p>
                                </div>
                            </div> -->

                        </div>

                        <!-- Second Column -->
                        <div class="col-lg-4">

                            <div class="card shadow mb-4">
                                
                                <div class="card-header py-3 mb-2">

                                    <h6 class="m-0 font-weight-bold text-primary">Cadastrar Colaborador</h6>

                                </div>

                                <?php if($mensagemColaborador){?>

                                    <div class="text-center">
                                        <b class="text-success">
                                            Colaborador Cadastrado com Sucesso !
                                        </b>
                                    </div>

                                <?php }?>
                                
                                <div class="card-body">
                                
                                    <form action="../Grupos/recebe_dados_grupo.php" method="post" id="formularioColaborador">

                                        <input type="hidden" name="acao" value="inserirColaborador">

                                        <div class="mb-2">
                                            <label for="nomeCompleto" class="nomeCompletoLabel">Nome Completo</label>
                                            <input type="text" name="nomeCompleto" class="form-control text-primary">
                                        </div>

                                        <div class="mb-2">
                                            <label for="cpfColaborador" class="cpfColaborador">CPF</label>
                                            <input type="text" id="cpfColaborador" name="cpfColaborador" class="form-control text-primary">
                                        </div>

                                        <div class="mb-2">
                                            <label for="emailColaborador" class="emailColaborador">E-mail</label>
                                            <input type="email" id="emailColaborador" name="emailColaborador" class="form-control text-primary">
                                        </div>

                                        <div class="mb-2">
                                            <label for="dataNascimentoColaborador" class="dataNascimentoColaborador">Data de Nascimento</label>
                                            <input type="date" id="dataNascimentoColaborador" name="dataNascimentoColaborador" class="form-control text-primary">
                                        </div>

                                        <div class="mb-2 ufs_br"></div>

                                        <div class="mb-2">
                                            <label for="numeroIdentidadeColaborador" class="numeroIdentidadeColaborador">Número Identidade</label>
                                            <input type="text" id="numeroIdentidadeColaborador" name="numeroIdentidadeColaborador" class="form-control text-primary">
                                        </div>

                                        <div class="mb-2">
                                            <label for="cepColaborador" class="cepColaborador">CEP</label>
                                            <input type="text" id="cepColaborador" name="cepColaborador" class="form-control text-primary">
                                        </div>

                                        <div class="mb-2">
                                            <label for="grupoColaborador" class="grupoColaborador">Selecione um Grupo:</label>
                                            <select name="grupoColaborador" id="grupoColaborador" class="form-control text-primary">

                                                <?php if($todosGrupos){?>

                                                    <option value="selecione"> -- SELECIONE -- </option>

                                                    <?php foreach($todosGrupos AS $cadaGrupo){?>

                                                        <option value="<?=$cadaGrupo['codigo_grupo']?>"><?=$cadaGrupo['nome']?></option>

                                                    <?php }?>

                                                <?php }else{?>
                                                    <option value="grupoVazio" selected>Não Possui Grupo Cadastrado</option>
                                                <?php }?>
                                            </select>
                                        </div>

                                        <div class="todosDadosDoEndereco"></div>

                                        <div class="text-center mb-2">
                                            <button type="button" class="btn btn-facebook btn-sm" id="criarColaboradorFormulario">Criar Colaborador</button>
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <!-- Third Column -->
                        <div class="col-lg-4">

                            <!-- Grayscale Utilities -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 mb-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Listagem De Grupos</h6>
                                </div>

                                <?php if($mensagemGrupoAlterado){?>

                                    <div class="text-center">
                                        <b class="text-success">
                                            Grupo Editado com Sucesso !
                                        </b>
                                    </div>

                                <?php }?>

                                <div class="card-body">
                                    
                                <?php if($todosGrupos){?>

                                    <?php foreach($todosGrupos AS $key => $cadaGrupo){?>
                                        
                                        <div class="card border-left-primary shadow h-100 py-2 mb-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            <?=$cadaGrupo['nome']?>
                                                        </div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditaGrupo<?=$key?>">
                                                                Editar
                                                            </button>      
                                                            
                                                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalListaColaboradores<?=$key?>">
                                                                Colaboradores
                                                            </button>  
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para exibir Informações do grupo -->
                                        <div class="modal fade" id="modalEditaGrupo<?=$key?>" tabindex="-1" aria-labelledby="modalEditaGrupoUsuarios" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditaGrupoUsuarios"><?=$cadaGrupo['nome']?></h5>
                                                        
                                                    </div>

                                                    <form action="../Grupos/editar_dados_grupo.php" method="post" id="formularioEditaGrupo">

                                                        <input type="hidden" name="acao" value="editar">

                                                        <input type="hidden" name="codigo_grupo" value="<?=$cadaGrupo['codigo_grupo']?>">

                                                        <div class="modal-body">
                                                            <p class="text-primary">
                                                                Editar Informações Referentes ao Grupo Selecionado !
                                                            </p>
    
                                                            <div class="mb-2">
                                                                <label class="labelNomeGrupoCriado">Nome do Grupo</label>
                                                                <input type="text" class="form-control text-primary" name="nomeGrupoCriado" required value="<?=$cadaGrupo['nome']?>">
                                                            </div>
    
                                                            <div class="mb-2">
                                                                <label class="labelDescricaoGrupoCriado">Descrição do Grupo</label>
                                                                <textarea name="descricaoGrupoCriado" class="form-control text-primary"><?=$cadaGrupo['descricao']?></textarea>
                                                            </div>
    
                                                        </div>

                                                        <div class="modal-footer">
    
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
    
                                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    
                                                        </div>

                                                    </form>


                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para Listar Colaboradores grupo -->
                                        <div class="modal fade" id="modalListaColaboradores<?=$key?>" tabindex="-1" aria-labelledby="modalListagem" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalListagem"><?=$cadaGrupo['nome']?></h5>
                                                        
                                                    </div>

                                                    <div class="modal-body">
                                                        <p class="text-primary">
                                                            Veja Abaixo Todos os Colaboradores Vinculados ao grupo de <b><?=$cadaGrupo['nome']?></b> !
                                                        </p>

                                                        <div class="mt-3">
                                                            <?php $pessoasDoGrupo = $grupos->listaTodasPessoasDoGrupo($cadaGrupo['codigo_grupo']);?>

                                                            <?php if($pessoasDoGrupo){?>
                                                                <?php foreach($pessoasDoGrupo AS $cadaPessoa){?>
                                                                    <p>
                                                                        <b class="text-primary">
                                                                            <?=$cadaPessoa['nome']?>
                                                                        </b>
                                                                    </p>
                                                                    <hr>
                                                                <?php }?>
                                                            <?php } else{?>
                                                                <p class="text-danger mt-3">
                                                                    <b>
                                                                        Não Encontramos nenhuma Pessoa Vinculada ao Grupo: <?=$cadaGrupo['nome']?>.
                                                                    </b>
                                                                </p>
                                                            <?php }?>

                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
    
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
    
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <?php }?>

                                <?php }?>
                                                      
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Desenvolvido por: <b>Agenda Contabilidade</b>, <?=date('Y')?></span>
                    </div>
                </div>
            </footer>

        </div>

    </div>
  
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once('../view/logout.php');?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <script src="../vendor/jquery/jquery.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../Public/js/jquery.mask.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

    <script src="../Public/js/grupo.js"></script>

</body>

</html>