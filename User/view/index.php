<?php 

    if(isset($_GET['login']) && $_GET['login'] == "erro"){
        $mensagemlogin = true;
    }else{
        $mensagemlogin = false;
    }

    if(isset($_GET['cadastro']) && $_GET['cadastro'] == "sucesso"){
        $mensagemCadastro = true;
    }else{
        $mensagemCadastro = false;
    }

    if(isset($_GET['erro']) && $_GET['erro'] == "cadastro"){
        $mensagemCadastroErro = true;
    }else{
        $mensagemCadastroErro = false;
    }

    if(isset($_GET['senha']) && $_GET['senha'] == "sucesso"){
        $mensagemSenha = true;
    }else{
        $mensagemSenha = false;
    }

    if(isset($_GET['senha']) && $_GET['senha'] == "erro"){
        $mensagemSenhaErro = true;
    }else{
        $mensagemSenhaErro = false;
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

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Hospital Irmã Denise - Login</title>
</head>

<body>
    
    <main>

        <div class="container col-xl-10 col-xxl-8 px-3 py-3">

            <a href="../../index.php" class="link_login text-primary">
                <i class='bx bx-left-arrow-circle text-primary' style="font-size:1.4rem"></i> Voltar Página Principal
            </a>

            <div class="row align-items-center g-lg-5 py-5">

                <div class="col-lg-7 text-center text-lg-start">

                    <p class="col-lg-10 fs-4">

                        <img src="../../Admin/Public/img/logo.png" alt="Logo" class="img__logo_login">

                    </p>

                </div>

                <div class="col-md-10 mx-auto col-lg-5">

                    <?php if($mensagemlogin){?>
                        <div class="erro_login w-100 text-center">
                            
                            <span class="text-danger text-center">

                                <i class='bx bx-info-circle'></i>Ocorreu um erro ao fazer o login !

                            </span>

                        </div>
                    <?php }?>

                    <?php if($mensagemCadastro){?>
                        <div class="erro_login w-100 text-center">
                            
                            <span class="text-success text-center">

                                <i class='bx bx-check'></i>Cadastro realizado com sucesso verifique seu e-mail !

                            </span>

                        </div>
                    <?php }?>

                    <?php if($mensagemCadastroErro){?>
                        <div class="erro_login w-100 text-center">
                            
                            <span class="text-danger text-center">

                                <i class='bx bx-info-circle'></i>Existe um usuário criado com os dados informados !

                            </span>

                        </div>
                    <?php }?>

                    <?php if($mensagemSenha){?>
                        <div class="erro_login w-100 text-center">
                            
                            <span class="text-success text-center">

                                <i class='bx bx-check'></i>Verifique sua caixa de e-mail !

                            </span>

                        </div>
                    <?php }?>

                    <?php if($mensagemSenhaErro){?>
                        <div class="erro_login w-100 text-center">
                            
                            <span class="text-success text-danger">

                            <i class='bx bx-info-circle'></i>Não encontramos o e-mail informado, realize seu cadastro!

                            </span>

                        </div>
                    <?php }?>

                    <form class="p-4 p-md-5 border rounded-3 bg-light" id="formulario_login" action="../Paciente/recebe_dados_paciente.php" method="post">

                        <input type="hidden" name="acao" value="login">

                        <div class="form-floating mb-3">

                            <input type="text" class="form-control" id="login" placeholder=" " name="login">

                            <label for="login" class="label_login_paciente">Login</label>

                        </div>

                        <div class="form-floating mb-3">

                            <input type="password" class="form-control" id="senha" placeholder=" " name="senha">

                            <label for="senha" class="label_senha_paciente">Senha</label>

                        </div>
                        
                        <div class="escopo_botao_login">
                            <button class="w-100 btn btn-lg btn-primary" type="button" id="botao_logar_paciente">Entrar</button>
                        </div>

                        <hr class="my-4">

                        <small class="text-muted">

                            <a href="../../cadastro.php" class="text-primary">Clique aqui para realizar o seu cadastro !</a>

                        </small>

                        <br>

                        <small class="text-muted">

                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#modalSenha">Esqueceu sua senha ?</a>

                        </small>

                        <br>
                        
                        <small class="text-muted">

                            <a href="./administrador.php" class="text-primary">Administrador</a>

                        </small>

                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="modalSenha" tabindex="-1" aria-labelledby="senha" aria-hidden="true">
                        <div class="modal-dialog">

                            <form action="../Paciente/redefinir_senha.php" method="post" id="formulario_atualiza_senha">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-primary" id="senha"><i class='bx bx-lock-alt mr-2'></i>     Redefinir Senha:</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating">
                                            <input type="email" id="email" name="emailSenha" placeholder=" " class="form-control">
                                            <label for="email">Digite seu e-mail</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <div class="botao_senha">
                                            <button type="button" class="btn btn-primary" id="botao_redefinir_senha">Redefinir senha</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>


                </div>

            </div>

        </div>

    </main>

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