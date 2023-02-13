<?php

    if(isset($_GET['msg']) && $_GET['msg'] == "erro"){
        $exibeErro = true;
    }else{
        $exibeErro = false;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="shortcut icon" href="../Public/img/cropped-casufunec.webp" type="image/x-icon">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="../Public/css/estilo_administrador.css" type="text/css" rel="stylesheet">

    <title>Hospital Irmã Denise - Login</title>
</head>

<body class="cor_de_fundo">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
    
                        <div class="row">

                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="../Public/img/logo_recorte.png" alt="Logo Recorte" class="ml-5 mt-3">
                            </div>

                            <div class="col-lg-6">

                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bem vindo de Volta!</h1>
                                    </div>

                                    <?php if($exibeErro){?>
                                        <label class="text-danger"><i class='bx bx-error-circle mr-2'></i>Não econtramos usuário cadastrado com os dados informados !</label>
                                    <?php }?>

                                    <form class="user" id="form_login" method="post" action="../Login/verifica_acesso.php">

                                        <div class="form-group">

                                            <input type="text" class="form-control form-control-user" name="login" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Digite seu login ...">

                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="senha" id="exampleInputPassword" placeholder="Senha">
                                        </div>
                                        
                                        <div class="form-button__login">
                                            <a href="#" class="btn btn-user btn-block cor_de_fundo cor_fonte_negrito" id="verificaDadosFormulario">
                                                Entrar
                                            </a>
                                        </div>

                                        <hr>

                                    </form>

                                    <hr>

                                    <div class="text-center">
                                        <a class="small text-dark" href="./redefinirSenha.html">Esqueceu sua Senha ?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ==================== JQUERY  ======================== -->
    <script src="../Public/js/jquery.js"></script>

    <!-- ==================== JS LOGIN  ======================== -->
    <script src="../Public/js/login.js"></script>

</body>

</html>