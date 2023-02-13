<?php 

    include_once '../src/functions.php';
    include_once '../fpdf/fpdf.php';

    // INSTÂNCIAS USADAS
    spl_autoload_register(function($class){
        require_once("../src/".$class.".php");
    });

    $pdf                = new FPDF("P","pt","A4");
    $data               = date("d/m/Y");
    $casuEmpresa        = new Casu();
    $grupo              = new Grupo();
    $paciente           = new Paciente();
    $categoriaServico   = new ServicoCategoria();
    
    if(isset($_GET['codigoGrupo']) && $_GET['codigoGrupo'] != NULL){
        
        $detalhesDoGrupo    = $grupo->retornaTodosDadosDoGrupo($_GET['codigoGrupo']);

        $pdf->AddPage();
        $pdf->SetXY(15,15);
        $pdf->Cell(563,90,"",1,1,'C');
        $pdf->SetFont('Arial','B',15);
        $pdf->SetXY(195,25);
        $pdf->Cell(5,15,"{$casuEmpresa->nomeEmpresa}");
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(425,55);
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(45,0,"Relatório de Grupos");
        $pdf->SetXY(250,40);
        $pdf->Image('../Public/img/logo.png', 40, 25, 150, 60);
        $pdf->SetXY(495,95);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(45,0,"Emissão: {$data}");

        $pdf->SetXY(240,120);
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(563, 20, 'Detalhes do Grupo');


        $pdf->SetFont('Arial','B',6);
        $pdf->SetXY(28,150);
        $pdf->Cell(150,15,"NOME DO GRUPO",1,1,'C');  
        $pdf->SetXY(178,150);
        $pdf->Cell(385,15,"DESCRIÇÃO",1,1,'C');

        $pdf->SetFont('Arial','',6);
        $pdf->Cell(150,15,"{$detalhesDoGrupo[0]['nome']}",1,0,'L');
        $pdf->Cell(385,15,"{$detalhesDoGrupo[0]['descricao']}",1,1,'L');

        // Pessoas vinculadas a um grupo
        $pdf->SetXY(240,200);
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(563, 20, 'Pessoas do Grupo');

        $pdf->SetFont('Arial','B',6);
        $pdf->SetXY(28,230);
        $pdf->Cell(125,15,"NOME DO COLABORADOR",1,1,'C');  
        $pdf->SetXY(153,230);
        $pdf->Cell(55,15,"CPF",1,1,'C');
        $pdf->SetXY(208,230);
        $pdf->Cell(120,15,"E-MAIL",1,1,'C');
        $pdf->SetXY(328,230);
        $pdf->Cell(80,15,"DATA DE NASCIMENTO",1,1,'C');
        $pdf->SetXY(408,230);
        $pdf->Cell(50,15,"IDENTIDADE",1,1,'C');
        $pdf->SetXY(458,230);
        $pdf->Cell(105,15,"DATA DA INCLUSÃO NO GRUPO",1,1,'C');
        
        

        $pdf->SetFont('Arial','',6);
        foreach($detalhesDoGrupo AS $cadaDetalhe){

            $cpf                = mask($cadaDetalhe['cpf'], "###.###.###-##");
            $numeroIdentidade   = mask($cadaDetalhe['numero_identidade'], "##.###.###");
            $rg                 = $cadaDetalhe['estado_identidade']." - ".$numeroIdentidade;

            $pdf->Cell(125,15,"{$cadaDetalhe['nome_pessoa']}",1,0,'L');
            $pdf->Cell(55,15,"{$cpf}",1,0,'L');
            // $pdf->SetXY(208,245);
            $pdf->Cell(120,15,"{$cadaDetalhe['email']}",1,0,'L');
            // $pdf->SetXY(288,245);
            $pdf->Cell(80,15,"{$cadaDetalhe['data_nascimento']}",1,0,'L');
            // $pdf->SetXY(368,245);
            $pdf->Cell(50,15,"{$rg}",1,0,'L');
            // $pdf->SetXY(448,245);
            $pdf->Cell(105,15,"{$cadaDetalhe['data_vinculo']}",1,0,'L');
            $pdf->Ln();
        }
    
    
        $pdf->Output('', 'RelatorioGrupo');

    }elseif(isset($_GET['pacientes']) && $_GET['pacientes'] != NULL){

        $todosPacientes     = $paciente->retornaTodosDadosDoPaciente(NULL);

        if($_GET['pacientes'] == "todos"){

            $pdf->AddPage();
            $pdf->SetXY(15,15);
            $pdf->Cell(563,90,"",1,1,'C');
            $pdf->SetFont('Arial','B',15);
            $pdf->SetXY(195,25);
            $pdf->Cell(5,15,"{$casuEmpresa->nomeEmpresa}");
            $pdf->SetFont('Arial','',9);
            $pdf->SetXY(410,55);
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(45,0,"Relatório de Pacientes");
            $pdf->SetXY(250,40);
            $pdf->Image('../Public/img/logo.png', 40, 25, 150, 60);
            $pdf->SetXY(495,95);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(45,0,"Emissão: {$data}");

            $pdf->SetFont('Arial','',6);

            $pdf->SetXY(240,115);
            $pdf->SetFont('Arial','B',13);
            $pdf->Cell(563, 20, 'Todos Pacientes');

            $pdf->SetFont('Arial','B',6);
            $pdf->SetXY(28,135);
            $pdf->Cell(125,15,"NOME",1,1,'C');  
            $pdf->SetXY(153,135);
            $pdf->Cell(55,15,"CPF",1,1,'C');
            $pdf->SetXY(208,135);
            $pdf->Cell(120,15,"E-MAIL",1,1,'C');
            $pdf->SetXY(328,135);
            $pdf->Cell(80,15,"DATA DE NASCIMENTO",1,1,'C');
            $pdf->SetXY(408,135);
            $pdf->Cell(50,15,"TELFONE",1,1,'C');
            $pdf->SetXY(458,135);
            $pdf->Cell(105,15,"CELULAR",1,1,'C');
            
            

            $pdf->SetFont('Arial','',6);
            foreach($todosPacientes AS $cadaPaciente){

                $cpf                = mask($cadaPaciente['cpf_paciente'], "###.###.###-##");
                
                if($cadaPaciente['telefone']){
                    $telefone       = mask($cadaPaciente['telefone'], "(##)####-####");
                }else{
                    $telefone       = "";
                }

                if($cadaPaciente['celular']){
                    $celular        = mask($cadaPaciente['celular'], "(##)#####-####");
                }else{
                    $celular        = "";
                }

                $pdf->Cell(125,15,"{$cadaPaciente['nome_paciente']}",1,0,'L');
                $pdf->Cell(55,15,"{$cpf}",1,0,'L');
                
                $pdf->Cell(120,15,"{$cadaPaciente['login_paciente']}",1,0,'L');

                $pdf->Cell(80,15,"{$cadaPaciente['data_nascimento_formatado']}",1,0,'L');

                $pdf->Cell(50,15,"{$telefone}",1,0,'L');

                $pdf->Cell(105,15,"{$celular}",1,0,'L');
                $pdf->Ln();
            }
        
        
            $pdf->Output('', 'RelatorioPacientes');

        }

    }elseif(isset($_GET['grupos']) && $_GET['grupos'] != NULL){

        $todosGrupos   = $grupo->retornaTodosGruposCadastrados();

        if($_GET['grupos'] == "todos"){

            $pdf->AddPage();
            $pdf->SetXY(15,15);
            $pdf->Cell(563,90,"",1,1,'C');
            $pdf->SetFont('Arial','B',15);
            $pdf->SetXY(195,25);
            $pdf->Cell(5,15,"{$casuEmpresa->nomeEmpresa}");
            $pdf->SetFont('Arial','',9);
            $pdf->SetXY(425,55);
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(45,0,"Relatório de Grupos");
            $pdf->SetXY(250,40);
            $pdf->Image('../Public/img/logo.png', 40, 25, 150, 60);
            $pdf->SetXY(495,95);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(45,0,"Emissão: {$data}");

            $pdf->SetFont('Arial','',6);

            $pdf->SetXY(240,115);
            $pdf->SetFont('Arial','B',13);
            $pdf->Cell(563, 20, 'Todos Grupos');

            $pdf->SetFont('Arial','B',6);
            $pdf->SetXY(28,135);
            $pdf->Cell(125,15,"NOME",1,1,'C');  
            $pdf->SetXY(153,135);
            $pdf->Cell(280,15,"DESCRIÇÃO",1,1,'C');
            $pdf->SetXY(433,135);
            $pdf->Cell(135,15,"DATA E HORA DE CRIAÇÃO",1,1,'C');
            
            

            $pdf->SetFont('Arial','',6);
            foreach($todosGrupos AS $cadaGrupo){

                $pdf->Cell(125,15,"{$cadaGrupo['nome']}",1,0,'L');

                // Vamos retornar as pessoas do grupo para listar no relatório
                $todasPessoasDoGrupo    = $grupo->listaTodasPessoasDoGrupo($cadaGrupo['codigo_grupo']);

                if($todasPessoasDoGrupo){
                    
                    $pdf->Cell(280,15,"{$cadaGrupo['descricao']}",1,0,'L');
                    $pdf->Cell(135,15,"{$cadaGrupo['data_criacao_formatada']}",1,0,'L');
                    foreach($todasPessoasDoGrupo AS $cadaPessoaDoGrupo){

                        $cpf        = mask($cadaPessoaDoGrupo['cpf'], "###.###.###-##");

                        $pdf->Ln();
                        $pdf->SetFont('Arial','B',8);
                        $pdf->SetTextColor(93, 173, 226);
                        $pdf->Cell(563, 20, "       Usuários do Grupo: {$cadaGrupo['nome']}", 0, 0, 'L');
                        $pdf->SetFont('Arial','',9);
                        $pdf->Ln();
                        $pdf->SetTextColor(17, 122, 101);
                        $pdf->Cell(125,15,"         {$cadaPessoaDoGrupo['nome']}        - {$cpf}",0,0,'L');
                        $pdf->Ln();
                        $pdf->SetFont('Arial','',6);
                        $pdf->SetTextColor(0, 0, 0);
                    }
                }else{
                    $pdf->Cell(280,15,"{$cadaGrupo['descricao']}",1,0,'L');
                    $pdf->Cell(135,15,"{$cadaGrupo['data_criacao_formatada']}",1,0,'L');
                    $pdf->Ln();
                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetTextColor(93, 173, 226);
                    $pdf->Cell(563, 20, "       Usuários do Grupo: {$cadaGrupo['nome']}", 0, 0, 'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Ln();
                    $pdf->SetTextColor(231, 76, 60);
                    $pdf->Cell(125,15,"         Não Possuem Pessoas Vinculadas ao Grupo !",0,0,'L');
                    $pdf->Ln();
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetFont('Arial','',6);
                }
                


                
                $pdf->Ln();
            }
        
        
            $pdf->Output('', 'RelatorioGrupo');

        }
    }else if(isset($_GET['categoria']) && $_GET['categoria'] != NULL){

        if($_GET['categoria'] == "todas"){

            $todasCategorias    = $categoriaServico->listaTodasCategorias("todas");

            $pdf->AddPage();
            $pdf->SetXY(15,15);
            $pdf->Cell(563,90,"",1,1,'C');
            $pdf->SetFont('Arial','B',15);
            $pdf->SetXY(195,25);
            $pdf->Cell(5,15,"{$casuEmpresa->nomeEmpresa}");
            $pdf->SetFont('Arial','',9);
            $pdf->SetXY(402,55);
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(45,0,"Relatório de Categorias");
            $pdf->SetXY(250,40);
            $pdf->Image('../Public/img/logo.png', 40, 25, 150, 60);
            $pdf->SetXY(495,95);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(45,0,"Emissão: {$data}");

            $pdf->SetFont('Arial','',6);

            $pdf->SetXY(240,115);
            $pdf->SetFont('Arial','B',13);
            $pdf->Cell(563, 20, 'Todas Categorias');

            $pdf->SetFont('Arial','B',6);
            $pdf->SetXY(28,135);
            $pdf->Cell(125,15,"NOME",1,1,'C');  
            $pdf->SetXY(153,135);
            $pdf->Cell(280,15,"DESCRIÇÃO",1,1,'C');
            $pdf->SetXY(433,135);
            $pdf->Cell(135,15,"STATUS",1,1,'C');
            
            

            $pdf->SetFont('Arial','',6);
            foreach($todasCategorias AS $cadaCategoria){

                if($cadaCategoria['status'] == "inativa"){

                    $pdf->SetTextColor(255, 0, 0);

                    $pdf->Cell(125,15,"{$cadaCategoria['nome']}",1,0,'L');
    
                    $pdf->Cell(280,15,"{$cadaCategoria['descricao']}",1,0,'L');
                    
                    $pdf->Cell(135,15,"{$cadaCategoria['status']}",1,0,'L');

                }else{

                    $pdf->SetTextColor(0,0,0);

                    $pdf->Cell(125,15,"{$cadaCategoria['nome']}",1,0,'L');
    
                    $pdf->Cell(280,15,"{$cadaCategoria['descricao']}",1,0,'L');
                    
                    $pdf->Cell(135,15,"{$cadaCategoria['status']}",1,0,'L');
    
                }

                $pdf->Ln();

            }
    
            $pdf->Output('', 'RelatorioCategorias');
        }
    }
?>