<?php
    include_once '../src/functions.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    if(isset($_GET['servico']) && $_GET['servico'] == "inserido"){
        $exibeMensagemCadastro  = true;
    }else{
        $exibeMensagemCadastro  = false;
    }

    if(isset($_GET['servico']) && $_GET['servico'] == "alterado"){
        $exibeMensagemAlteracao  = true;
    }else{
        $exibeMensagemAlteracao  = false;
    }

    $categorias         = new ServicoCategoria();
    $tipoCategoria      = new ServicoCategoriaTipo();
    
    // Todas categorias ativas.
    $categoriasAtivas   = $categorias->listaTodasCategorias();

    // Todos tipos de categoria.
    $tiposCategorias    = $tipoCategoria->listaTodosTiposCategoria();

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

    <title>Hospital Irmã Denise - Serviços Categorias</title>
</head>

<body id="page-top" onclick="removeListaAutoComplete();">

    <div id="wrapper">

        <!--===INCLUINDO SIDEBAR PADRÃO==-->
        <?php include '../view/sidebar.php';?>
        
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!--===INCLUINDO NAVBAR PADRÃO==-->
                <?php include '../view/navbar.php'?>

                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800">Serviços - Tipos de Categorias</h1>
                    <p>
                        Realize a criação de tipos categorias.
                    </p>

                    <div class="row">

                        <div class="col-xl-8 col-lg-7">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Criação de Tipos Categoria de Seriços:</h6>
                                </div>

                                <?php if($exibeMensagemCadastro){?>
                                    <div class="header-categoria mt-2 text-center">
                                        <b class="text-success">
                                            Tipo Categoria Cadastrada com Sucesso !
                                        </b>
                                    </div>
                                <?php }?>
                                
                                <div class="card-body">
                                    <form action="../Servicos/recebe_dados_tipo_categoria.php" method="post" id="formulario_servico_tipo_categoria">

                                        <input type="hidden" name="acao" value="inserir">

                                        <div class="mb-2">
                                            <label for="nome_categoria" class="label_nome_categoria">Nome do Tipo de Categoria:</label>
                                            <input type="text" class="form-control" id="nome_categoria" name="nome">
                                        </div>

                                        <div class="mb-2">
                                            <label for="descricao">Descrição do Tipo de categoria   <span class="text-primary">(Opcional)</span></label>
                                            <textarea class="form-control" id="descricao" name="descricao"></textarea>
                                        </div>

                                        <div class="mb-2">
                                            <label for="categorias" class="label_categoria">Categorias</label>
                                            <select name="categoria" id="categorias" class="form-control">

                                                <?php if($categoriasAtivas){?>

                                                    <option value="selecione"> -- SELECIONE -- </option>

                                                    <?php foreach($categoriasAtivas AS $cadaCategoria){?>

                                                        <option value="<?=$cadaCategoria['codigo_servico_categoria']?>"><?=$cadaCategoria['nome']?></option>

                                                    <?php }?>

                                                <?php } else { ?>
                                                    <option value="selecione">Não existem categorias cadastradas !</option>
                                                <?php }?>

                                            </select>

                                        </div>

                                        <hr>
                                        
                                        <div class="botao_categoria text-center">
                                            <button type="button" class="btn btn-facebook btn-sm" id="botao_salva_tipo_categoria_servico">Salvar Categoria</button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                        
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4 barra_rolagem_tipo_categorias">
                                
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Listagem de Categorias</h6>
                                </div>

                                <?php if($exibeMensagemAlteracao){?>
                                    <div class="header-categoria mt-2 text-center">
                                        <b class="text-success">
                                            Tipo Categoria Atualizada com Sucesso !
                                        </b>
                                    </div>
                                <?php }?>
                                
                                <div class="card-body">

                                    <?php if($tiposCategorias){?>

                                        <?php foreach($tiposCategorias AS $key => $cadaTipoCategoria){?>

                                            <b class="text-primary">
                                                Nome: <span class="text-secondary"><?=$cadaTipoCategoria['nome']?></span>
                                            </b>

                                            
                                            <span class="botao_detalhes_categoria" data-toggle="modal" data-target="#exibeDetalhesCategoria<?=$key?>">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class='bx bx-edit-alt'></i>
                                                </button>
                                            </span>

                                            <hr>

                                            <!-- Modal Exibe Detalhes Categoria-->
                                            <div class="modal fade" id="exibeDetalhesCategoria<?=$key?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                <div class="modal-dialog modal-lg">

                                                    <form action="../Servicos/recebe_dados_tipo_categoria.php" method="post">

                                                        <input type="hidden" name="acao" value="atualizar">

                                                        <input type="hidden" name="codigoCategoria" value="<?=$cadaTipoCategoria['codigo_servico_categoria_tipo']?>">

                                                        <div class="modal-content">
    
                                                            <div class="modal-header">
    
                                                                <h5 class="modal-title" id="exampleModalLabel"><i class='bx bx-edit-alt mr-2 text-primary'></i>   Dados do Tipo Categoria</h5>
    
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    
                                                                    <span aria-hidden="true">&times;</span>
    
                                                                </button>
    
                                                            </div>
    
                                                            <div class="modal-body">
    
                                                                <div class="row">

                                                                    <div class="col">
                                                                        <label for="nome_categoria">Nome</label>
                                                                        <input type="text" class="form-control" name="nome" value="<?=$cadaTipoCategoria['nome']?>" required>
                                                                    </div>

                                                                    <div class="col">
                                                                        <label for="categoria">Categoria</label>
                                                                        <select name="categoria" id="categoria" class="form-control">

                                                                            <?php foreach($categoriasAtivas AS $cadaCategoria){?>

                                                                                <?php if($cadaCategoria['codigo_servico_categoria'] == $cadaTipoCategoria['codigo_servico_categoria']) {?>
                                                                                    <option value="<?=$cadaCategoria['codigo_servico_categoria']?>" selected><?=$cadaCategoria['nome']?></option>
                                                                                <?php }else{?>
                                                                                    <option value="<?=$cadaCategoria['codigo_servico_categoria']?>"><?=$cadaCategoria['nome']?></option>
                                                                                <?php }?>
                                                                                

                                                                            <?php } ?>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <label for="descricao">Descrição: <span class="text-primary">(Opcional)</span></label>
                                                                        <textarea name="descricao" id="descricao" class="form-control"><?=$cadaTipoCategoria['descricao']?></textarea>
                                                                    </div>
                                                                </div>
    
                                                            </div>
    
                                                            <div class="modal-footer">
    
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    
                                                                <button type="submit" class="btn btn-primary">Atualizar</button>
    
                                                            </div>
                                                            
                                                        </div>

                                                    </form>


                                                </div>

                                            </div>


                                        <?php }?>

                                    <?php }else{?>
                                        <div class="corpoCategorias text-center">
                                            <p>
                                                <b class="text-danger">
                                                    Não existem Categorias Cadastradas !
                                                </b>
                                            </p>
                                        </div>
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

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../Public/js/sb-admin-2.min.js"></script>

    <script src="../Public/js/verifica_tipo_categoria_servico.js"></script>

</body>

</html>