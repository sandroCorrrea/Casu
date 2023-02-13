<?php

    include_once '../../Admin/src/functions.php';
    include_once '../phpqrcode/qrlib.php';
    include_once '../../Admin/fpdf/fpdf.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../../Admin/src/".$class.".php");
    });

    // Iniciando a sessão ou verificando se o usuário possui a mesma.
    verificaSessaoUsuario();

    extract($_GET);

    $casu               = new Casu();
    $pdf                = new FPDF("P", "pt", "A4");
    $data               = date('d/m/Y');
    $paciente           = new Paciente();
    $servico            = new PacienteConsulta();
    $dadosDoServico     = $servico->retornaConsultaDoPaciente($_SESSION['codigo_paciente'], $codigo_agendamento);

    $dadosDoPaciente    = $paciente->retornaTodosDadosDoPaciente($_SESSION['codigo_paciente']);
    $dadosDoPaciente    = $dadosDoPaciente[0];

    $ipServidor         = retornaIpServidor();


    // Vamos gerar um arquivo em pdf com o seu comprovante em qr code.
    $qrCodeNome         = "imagem_qrcode_{$_SESSION['cpf']}_{$_SESSION['codigo_paciente']}_{$codigo_agendamento}.png";
    
    QRcode::png("http://169.254.9.241/Casu/User/Paciente/exibe_dados_protocolo.php?codigo_agendamento={$codigo_agendamento}&codigo_paciente={$_SESSION['codigo_paciente']}", $qrCodeNome);

    $pdf->AddPage();
    $pdf->SetXY(15,15);
    $pdf->Cell(563,90,"",1,1,'C');
    $pdf->SetFont('Arial','B',15);
    $pdf->SetXY(195,25);
    $pdf->Cell(5,15,"{$casu->nomeEmpresa}");
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(348,55);
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(45,0,"Comprovante de Agendamento");
    $pdf->SetXY(250,40);
    $pdf->Image('../../Admin/Public/img/logo.png', 20, 25, 180, 60);
    $pdf->SetXY(495,95);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(45,0,"Emissão: {$data}");

    $cnpj       = mask($casu->cnpjEmpresa, "##.###.###/####-##");
    $cep        = mask($casu->cepEmpresa, "#####-###");
    $telefone   = mask($casu->telefoneEmpresa, "(##)####-####");

    $pdf->SetXY(225,120);
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(563, 20, 'Detalhes do Agendamento');
    $pdf->SetXY(56,150);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetXY(56,150);
    $pdf->Cell(563, 40, 'Responsável pela geração do comprovante:', 0, 0, 'L');
    $pdf->SetXY(56,170);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Nome:', 0, 0, 'L');
    $pdf->SetXY(100,170);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$casu->nomeEmpresa}", 0, 0, 'L');
    $pdf->SetXY(56,190);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       CNPJ:', 0, 0, 'L');
    $pdf->SetXY(100,190);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$cnpj}", 0, 0, 'L');
    $pdf->SetXY(56,210);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       CEP:', 0, 0, 'L');
    $pdf->SetXY(100,210);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$cep}", 0, 0, 'L');
    $pdf->SetXY(56,230);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Logradouro:', 0, 0, 'L');
    $pdf->SetXY(128,230);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$casu->cidadeEmpresa}, {$casu->bairroEmpresa}, {$casu->ruaEmpresa} - {$casu->numeroEmpresa}", 0, 0, 'L');
    $pdf->SetXY(56,250);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       E-mail:', 0, 0, 'L');
    $pdf->SetXY(100,250);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$casu->emailEmpresa}", 0, 0, 'L');
    $pdf->SetXY(56,270);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Telefone:', 0, 0, 'L');
    $pdf->SetXY(110,270);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$telefone}", 0, 0, 'L');
    $pdf->Ln(40);
    $pdf->Cell(545, 1, '', 1);

    $cpfPaciente                                    = strtoupper(mask($dadosDoPaciente['cpf_paciente'], "###.###.###-##"));
    $cep                                            = mask($dadosDoPaciente['cep'], "#####-###");
    $dadosDoPaciente['nome_paciente']               = mb_strtoupper($dadosDoPaciente['nome_paciente']);
    $dadosDoPaciente['localidade']                  = mb_strtoupper($dadosDoPaciente['localidade']);
    $dadosDoPaciente['bairro']                      = mb_strtoupper($dadosDoPaciente['bairro']);
    $dadosDoPaciente['logradouro']                  = mb_strtoupper($dadosDoPaciente['logradouro']);
    $dadosDoPaciente['login_paciente']              = mb_strtoupper($dadosDoPaciente['login_paciente']);

    if($dadosDoPaciente['telefone']){
        $dadosDoPaciente['telefone']                = mask($dadosDoPaciente['telefone'], "(##)####-####");
    }else{
        $dadosDoPaciente['telefone']                = "";
    }

    $dadosDoPaciente['celular']                     = mask($dadosDoPaciente['celular'], "(##)#####-####");
    $dadosDoPaciente['numero_identidade']           = mask($dadosDoPaciente['numero_identidade'], "##.###.###");
    $dadosDoPaciente['orgao_expeditor_identidade']  = strtoupper($dadosDoPaciente['orgao_expeditor_identidade']);

    // Detalhes do paciente
    $pdf->SetXY(56,310);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(563, 40, 'Dados do paciente:', 0, 0, 'L');
    $pdf->SetXY(56,330);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Nome:', 0, 0, 'L');
    $pdf->SetXY(100,330);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['nome_paciente']}", 0, 0, 'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetXY(56,350);
    $pdf->Cell(563, 40, '       CPF:', 0, 0, 'L');
    $pdf->SetXY(100,350);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$cpfPaciente}", 0, 0, 'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetXY(56,370);
    $pdf->Cell(563, 40, '       CEP:', 0, 0, 'L');
    $pdf->SetXY(100,370);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$cep}", 0, 0, 'L');
    $pdf->SetXY(56,390);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Logradouro:', 0, 0, 'L');
    $pdf->SetXY(128,390);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['localidade']}, {$dadosDoPaciente['bairro']}, {$dadosDoPaciente['logradouro']}", 0, 0, 'L');
    $pdf->SetXY(56,410);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Email:', 0, 0, 'L');
    $pdf->SetXY(100,410);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['login_paciente']}", 0, 0, 'L');
    $pdf->SetXY(56,430);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Telefone:', 0, 0, 'L');
    $pdf->SetXY(100,430);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['telefone']}", 0, 0, 'L');
    $pdf->SetXY(56,450);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Celular:', 0, 0, 'L');
    $pdf->SetXY(100,450);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['celular']}", 0, 0, 'L');
    $pdf->SetXY(56,470);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Data de Nascimento:', 0, 0, 'L');
    $pdf->SetXY(160,470);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['data_nascimento_formatado']}", 0, 0, 'L');
    $pdf->SetXY(56,490);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(563, 40, '       Identidade:', 0, 0, 'L');
    $pdf->SetXY(115,490);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(563, 40, "       {$dadosDoPaciente['uf_identidade']}-{$dadosDoPaciente['numero_identidade']} {$dadosDoPaciente['orgao_expeditor_identidade']}", 0, 0, 'L');

    $pdf->Ln(40);
    $pdf->Cell(545, 1, '', 1);

    $pdf->SetXY(45,530);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(520, 40, 'COMPROVANTE QR CODE:', 0, 0, 'C');
    $pdf->Image("./imagem_qrcode_{$_SESSION['cpf']}_{$_SESSION['codigo_paciente']}_{$codigo_agendamento}.png", 175, 580, 250, 250);
    $pdf->Ln();

    $pdf->SetFont('Arial','B',10);

    if($dadosDoServico[0]['status'] == "deferido"){
        $status = "Deferido";
        $pdf->SetTextColor(5, 170, 85);
        $pdf->Cell(563, 0, "        Status: {$status}", 0, 0, "L");
    }else if($dadosDoServico[0]["status"] == "indeferido"){
        $status = "Indeferido";
        $pdf->SetTextColor(243, 0, 4);
        $pdf->Cell(563, 0, "        Status: {$status}", 0, 0, "L");
    }else{
        $status = "Em análise";
        $pdf->SetTextColor(219, 175, 4);
        $pdf->Cell(563, 0, "        Status: {$status}", 0, 0, "L");
    }
        
    $pdf->Output('', 'Comprovante');
?>