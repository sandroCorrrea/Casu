<?php

include_once '../src/functions.php';
include_once '../fpdf/fpdf.php';

// INSTÂNCIAS USADAS
spl_autoload_register(function ($class) {
    require_once("../src/" . $class . ".php");
});

$pdf                    = new FPDF("P", "pt", "A4");
$data                   = date("d/m/Y");
$casuEmpresa            = new Casu();
$agendamentoPaciente    = new Agendamento();

extract($_GET);
extract($_POST);

if(isset($relatorio)){

    if(!$inicio && !$fim && !$categoria){

        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL);

    }else if($inicio && $fim && !$categoria){

        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL, NULL, NULL, $inicio, $fim);

    }else if($inicio && $fim && $categoria){

        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL, NULL, NULL, $inicio, $fim, $categoria);

    }else if($inicio && !$fim && !$categoria){
        
        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL, NULL, NULL, $inicio);

    }else if(!$inicio && $fim && !$categoria){

        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL, NULL, NULL, NULL, $fim);

    }else if(!$inicio && !$fim && $categoria){

        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL, NULL, NULL, NULL, NULL, $categoria);

    }else{

        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo(NULL, NULL, NULL, NULL, NULL, NULL);
    }

}else{
    // Vamos consultar todos os agendamentos conforme for do desejo do usuário.
    if (isset($tipo) && $tipo == "diario") {
        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo("dia", date('d'), NULL);
    } else if (isset($tipo) && $tipo == "mes") {
        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo("mes", NULL, date('m'));
    } else {
        $agendamentosRealizados = $agendamentoPaciente->retornaTodosAgendamentosPorPeriodo("mes", NULL, date('m'));
    }
    
    $dataAgendamento    = explode("-", date('d-m-Y'));
    $ano                = end($dataAgendamento);
    $dia                = $dataAgendamento[0];
    $mes                = $dataAgendamento[1];
}



$pdf->AddPage();
$pdf->AliasNbPages();   
$pdf->SetXY(15, 15);
$pdf->Cell(563, 90, "", 1, 1, 'C');
$pdf->SetFont('Arial', 'B', 15);
$pdf->SetXY(195, 25);
$pdf->Cell(5, 15, "{$casuEmpresa->nomeEmpresa}");
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(315, 55);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(45, 0, "Relatório de Agendamentos (Diário)");
$pdf->SetXY(250, 40);
$pdf->Image('../Public/img/logo.png', 40, 25, 150, 60);
$pdf->SetXY(495, 95);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 0, "Emissão: {$data}");

$pdf->SetXY(200, 120);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(563, 20, 'Detalhes dos agendamentos');


$pdf->SetFont('Arial', 'B', 6);
$pdf->SetXY(28, 150);
$pdf->Cell(60, 15, "DATA", 1, 1, 'C');

$pdf->SetXY(88, 150);
$pdf->Cell(130, 15, "PROCEDIMENTO", 1, 1, 'C');

$pdf->SetXY(218, 150);
$pdf->Cell(130, 15, "PACIENTE", 1, 1, 'C');

$pdf->SetXY(348, 150);
$pdf->Cell(50, 15, "VALOR", 1, 1, 'C');

$pdf->SetXY(398, 150);
$pdf->Cell(80, 15, "CATEGORIA", 1, 1, 'C');

$pdf->SetXY(478, 150);
$pdf->Cell(100, 15, "STATUS", 1, 1, 'C');

$pdf->SetFont('Arial','',6);

if($agendamentosRealizados){

    $pdf->SetTextColor(0, 0, 0);

    if(is_array($agendamentosRealizados)){

        $quantidade     = sizeof($agendamentosRealizados);

    }else {

        $quantidade     = 0;

    }

    
    foreach($agendamentosRealizados AS $cadaAgendamento){
        $pdf->Cell(60,15,"{$cadaAgendamento['data_agendamento']}",1,0,'L');
        $pdf->Cell(130,15,"{$cadaAgendamento['nome_agendamento']}",1,0,'L');
        $pdf->Cell(130,15,"{$cadaAgendamento['nome_paciente']}",1,0,'L');
        $pdf->Cell(50,15,"{$cadaAgendamento['valor']}",1,0,'L');
        $pdf->Cell(80,15,"{$cadaAgendamento['categoria_formatada']}",1,0,'L');

        if($cadaAgendamento['status'] == "indeferido"){
            $pdf->SetTextColor(255, 0, 0);
            $status = "Indeferido";
            $pdf->Cell(100,15, $status,1,0,'L');
        }else if($cadaAgendamento['status'] == "analise"){
            $pdf->SetTextColor(255, 165, 0);
            $status = "Em Análise";
            $pdf->Cell(100,15, $status,1,0,'L');
        }else{
            $pdf->SetTextColor(60, 179, 113);
            $status = "Deferido";
            $pdf->Cell(100,15, $status,1,0,'L');
        }

        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln();
    }

    $pdf->Ln(50);
    $pdf->SetFont('Arial', 'B', 8);

    if(strlen($agendamentosRealizados[0]['valor_agendamento']) == 2){
        $agendamentosRealizados[0]['valor_agendamento'] = $agendamentosRealizados[0]['valor_agendamento'].",00";
    }else if(strlen($agendamentosRealizados[0]['valor_agendamento']) == 3){
        $agendamentosRealizados[0]['valor_agendamento'] = $agendamentosRealizados[0]['valor_agendamento'].",00";
    }else{
        $agendamentosRealizados[0]['valor_agendamento'] = str_replace(".", ",", $agendamentosRealizados[0]['valor_agendamento']); 
    }


    $pdf->Cell(563, 20, "Total de marcações: {$quantidade}                                                                                                        : R$ {$agendamentosRealizados[0]['valor_agendamento']}");

}else {

    $pdf->SetTextColor(255, 0, 0);
    
    $pdf->SetFont('Arial','',10);

    $pdf->Ln(40);

    $pdf->Cell(563, 20, "Não encontramos nenhum agendamento feito em {$data} !", 0, 0, 'C');

}

$pdf->Output('', 'RelatorioDiario');