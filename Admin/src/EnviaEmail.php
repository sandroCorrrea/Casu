<?php

    class EnviaEmail extends Casu{
        
        public $destinatario;
        public $titulo;
        public $emailRemetente;
        public $nomeRemetente;
        public $caminhoImagemCabecalho;
        public $caminhoImagemRodape;
        public $caminhoImagemPrincipal;
        public $caminhoImagemEmail;
        public $caminhoImagemTelefone;
        public $html;


        public function __construct($destinatario = NULL, $titulo = NULL, $nomeRemetente = NULL, $caminhoImagemCabecalho = NULL, $caminhoImagemRodape = NULL, $caminhoImagemPrincipal = NULL, $caminhoImagemEmail = NULL, $caminhoImagemTelefone = NULL, $html = NULL){

            $emailRemetente                 = "contabilidadeagenda2022@gmail.com";

            $this->destinatario             = $destinatario;
            $this->titulo                   = $titulo;
            $this->emailRemetente           = $emailRemetente;
            $this->nomeRemetente            = $nomeRemetente;
            $this->caminhoImagemCabecalho   = $caminhoImagemCabecalho;
            $this->caminhoImagemRodape      = $caminhoImagemRodape;
            $this->caminhoImagemPrincipal   = $caminhoImagemPrincipal;
            $this->caminhoImagemEmail       = $caminhoImagemEmail;
            $this->caminhoImagemTelefone    = $caminhoImagemTelefone;
            $this->html                     = $html;

            return true;
        }

        public function enviaEmailConfirmaCadastro($senha = NULL, $login = NULL, $grupo = NULL, $nomeColaborador){

            $mail   = new PHPMailer();
            $casu   = new Casu();

            $mail->isSMTP();
            $mail->CharSet      = 'UTF-8';
            $mail->Host         = 'smtp.gmail.com';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'contabilidadeagenda2022@gmail.com';
            $mail->Password     = "jyygpxajhbhqjfhx";
            $mail->Port = 587;
            $mail->setFrom($this->emailRemetente, $this->nomeRemetente);
            $mail->addAddress($this->destinatario);
            $mail->isHTML(true);
            $mail->Subject      = $this->titulo;

            $mail->addEmbeddedImage($this->caminhoImagemCabecalho, 'imagemCabecalho');
            $mail->addEmbeddedImage($this->caminhoImagemRodape, 'imagemRodape');
            $mail->addEmbeddedImage($this->caminhoImagemEmail, 'imagemEmail');
            $mail->addEmbeddedImage($this->caminhoImagemTelefone, 'imagemTelefone');
    
            $anoAtual = date('Y');

            $mail->Body = "
                <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                <html xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                        <title>Dados Cadasatro</title>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    </head>
            
                    <body style='margin: 0; padding: 0;'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                            <tr>
                                <td>
                                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border: 1px solid #cccccc;'>
                                        <tr>
                                            <td align='center' bgcolor='#70bbd9' style='padding: 40px 0 30px 0;'>
                                                <img src='cid:imagemCabecalho'style='display: block; width:50%;'/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#ffffff' style='padding: 40px 30px 40px 30px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%' >
                                                    <tr>
                                                        <td style='color: #153643; font-family: Arial, sans-serif; font-size: 15px;'>
                                                            <b>Olá {$nomeColaborador}, Tudo bem ?</b>
                                                            <p class='font-size: 10px;'>
                                                                Seguem Abaixo Suas Credenciais de Acesso ao Sistema:
                                                            </p>
                                                            <p>
                                                                <b>Login:</b> {$login}
                                                            </p>
                                                            <p>
                                                                <b>Senha:</b> {$senha}
                                                            </p>
                                                            <p>
                                                                <b>Grupo:</b> {$grupo}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: center;'>
                                                            <b>Bem Vindo ao Nosso Novo Sistema !</b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#5fa2bd' style='padding: 30px 30px 30px 30px; color: #f3f3f3; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td align='right'>
                                                            <table border='0' cellpadding='0' cellspacing='0'>
                                                                <tr>
                                                                    <td width='75%'>
                                                                        &reg; {$casu->nomeLegivelEmpresa}, {$casu->cidadeEmpresa} - {$casu->estadoEmpresa} {$anoAtual}<br/>
                                                                        E-mail Automático Gentileza Não Responder.
                                                                    </td>
                                                                    <td>
                                                                        <a href='https://wa.me/55{$casu->celularEmpresa}'>
                                                                            <img src='cid:imagemTelefone'>
                                                                        </a>
                                                                    </td>
                                                                    <td style='font-size: 0; line-height: 0;' width='20'>&nbsp;</td>
                                                                    <td>
                                                                        <a href='mailto:{$casu->emailEmpresa}' style='text-decoration: none;'>
                                                                            <img src='cid:imagemEmail'>
                                                                        </a>    
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: 0; line-height: 0;' height='10'>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                </html>
            ";
            
            $mail->send();
    
            return true;
        }

        public function enviaEmailConfirmaCadastroPaciente($senha = NULL, $login = NULL, $nomeColaborador){

            $mail   = new PHPMailer();
            $casu   = new Casu();
            
            $mail->isSMTP();
            $mail->CharSet      = 'UTF-8';
            $mail->Host         = 'smtp.gmail.com';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'contabilidadeagenda2022@gmail.com';
            $mail->Password     = "jyygpxajhbhqjfhx";
            $mail->Port = 587;
            $mail->setFrom($this->emailRemetente, $this->nomeRemetente);
            $mail->addAddress($this->destinatario);
            $mail->isHTML(true);
            $mail->Subject      = $this->titulo;
            
            $mail->addEmbeddedImage($this->caminhoImagemCabecalho, 'imagemCabecalho');
            $mail->addEmbeddedImage($this->caminhoImagemEmail, 'imagemEmail');
            $mail->addEmbeddedImage($this->caminhoImagemTelefone, 'imagemTelefone');
            
            $anoAtual = date('Y');

            $mail->Body = "
                <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                <html xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                        <title>Dados Cadasatro</title>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    </head>
            
                    <body style='margin: 0; padding: 0;'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                            <tr>
                                <td>
                                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border: 1px solid #cccccc;'>
                                        <tr>
                                            <td align='center' bgcolor='#70bbd9' style='padding: 40px 0 30px 0;'>
                                                <img src='cid:imagemCabecalho'style='display: block; width:50%;'/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#ffffff' style='padding: 40px 30px 40px 30px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%' >
                                                    <tr>
                                                        <td style='color: #153643; font-family: Arial, sans-serif; font-size: 15px;'>
                                                            <b>Olá {$nomeColaborador}, Tudo bem ?</b>
                                                            <p class='font-size: 10px;'>
                                                                Seguem Abaixo Suas Credenciais de Acesso ao Sistema:
                                                            </p>
                                                            <p>
                                                                <b>Login:</b> {$login}
                                                            </p>
                                                            <p>
                                                                <b>Senha:</b> {$senha}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: center;'>
                                                            <b>Bem Vindo ao Nosso Novo Sistema !</b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#5fa2bd' style='padding: 30px 30px 30px 30px; color: #f3f3f3; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td align='right'>
                                                            <table border='0' cellpadding='0' cellspacing='0'>
                                                                <tr>
                                                                    <td width='75%'>
                                                                        &reg; {$casu->nomeLegivelEmpresa}, {$casu->cidadeEmpresa} - {$casu->estadoEmpresa} {$anoAtual}<br/>
                                                                        E-mail Automático Gentileza Não Responder.
                                                                    </td>
                                                                    <td>
                                                                        <a href='https://wa.me/55{$casu->celularEmpresa}'>
                                                                            <img src='cid:imagemTelefone'>
                                                                        </a>
                                                                    </td>
                                                                    <td style='font-size: 0; line-height: 0;' width='20'>&nbsp;</td>
                                                                    <td>
                                                                        <a href='mailto:{$casu->emailEmpresa}' style='text-decoration: none;'>
                                                                            <img src='cid:imagemEmail'>
                                                                        </a>    
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: 0; line-height: 0;' height='10'>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                </html>
            ";

            $mail->send();
    
            return true;
        }

        public function redefinirSenha($senha = NULL, $login = NULL){

            $mail   = new PHPMailer();
            $casu   = new Casu();
            
            $mail->isSMTP();
            $mail->CharSet      = 'UTF-8';
            $mail->Host         = 'smtp.gmail.com';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'contabilidadeagenda2022@gmail.com';
            $mail->Password     = "jyygpxajhbhqjfhx";
            $mail->Port = 587;
            $mail->setFrom($this->emailRemetente, $this->nomeRemetente);
            $mail->addAddress($this->destinatario);
            $mail->isHTML(true);
            $mail->Subject      = $this->titulo;
            
            $mail->addEmbeddedImage($this->caminhoImagemCabecalho, 'imagemCabecalho');
            $mail->addEmbeddedImage($this->caminhoImagemEmail, 'imagemEmail');
            $mail->addEmbeddedImage($this->caminhoImagemTelefone, 'imagemTelefone');
            
            $anoAtual = date('Y');

            $mail->Body = "
                <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                <html xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                        <title>Dados Cadasatro</title>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    </head>
            
                    <body style='margin: 0; padding: 0;'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                            <tr>
                                <td>
                                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border: 1px solid #cccccc;'>
                                        <tr>
                                            <td align='center' bgcolor='#70bbd9' style='padding: 40px 0 30px 0;'>
                                                <img src='cid:imagemCabecalho'style='display: block; width:50%;'/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#ffffff' style='padding: 40px 30px 40px 30px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%' >
                                                    <tr>
                                                        <td style='color: #153643; font-family: Arial, sans-serif; font-size: 15px;'>
                                                            <b>Olá, Tudo bem ?</b>
                                                            <p class='font-size: 10px;'>
                                                                Vimos que você solicitou uma nova senha, seguem abaixo suas novas credencias de acesso para o sistema:
                                                            </p>
                                                            <p>
                                                                <b>Login:</b> {$login}
                                                            </p>
                                                            <p>
                                                                <b>Senha:</b> {$senha}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: center;'>
                                                            <b>Obrigado pela preferência !</b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#5fa2bd' style='padding: 30px 30px 30px 30px; color: #f3f3f3; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td align='right'>
                                                            <table border='0' cellpadding='0' cellspacing='0'>
                                                                <tr>
                                                                    <td width='75%'>
                                                                        &reg; {$casu->nomeLegivelEmpresa}, {$casu->cidadeEmpresa} - {$casu->estadoEmpresa} {$anoAtual}<br/>
                                                                        E-mail Automático Gentileza Não Responder.
                                                                    </td>
                                                                    <td>
                                                                        <a href='https://wa.me/55{$casu->celularEmpresa}'>
                                                                            <img src='cid:imagemTelefone'>
                                                                        </a>
                                                                    </td>
                                                                    <td style='font-size: 0; line-height: 0;' width='20'>&nbsp;</td>
                                                                    <td>
                                                                        <a href='mailto:{$casu->emailEmpresa}' style='text-decoration: none;'>
                                                                            <img src='cid:imagemEmail'>
                                                                        </a>    
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: 0; line-height: 0;' height='10'>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                </html>
            ";

            $mail->send();
    
            return true;
        }
    }
?>