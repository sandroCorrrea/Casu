<?php

    class Casu extends Conexao {

        public $nomeEmpresa;
        public $cnpjEmpresa;
        public $cepEmpresa;
        public $ruaEmpresa;
        public $bairroEmpresa;
        public $cidadeEmpresa;
        public $estadoEmpresa;
        public $numeroEmpresa;
        public $telefoneEmpresa;
        public $emailEmpresa;
        public $inscricaoEstadualEmpresa;
        public $tipoEmpresa;
        public $dataSituacaoUfEmpresa;
        public $situacaoCnpjEmpresa;
        public $situacaoInscricaoEstadualEmpresa;
        public $cnaeEmpresa;
        public $celularEmpresa;
        public $nomeLegivelEmpresa;
        public $codigoEmpresa;

        public function __construct(){

            $sql = "SELECT
                        nome,
                        cnpj,
                        cep,
                        rua,
                        bairro,
                        cidade,
                        uf,
                        numero,
                        telefone,
                        email,
                        inscricao_estadual,
                        tipo,
                        data_situacao_uf,
                        situacao_cnpj,
                        situacao_ie,
                        cnae_empresa,
                        nome_legivel,
                        celular_empresa,
                        codigo_empresa
                    FROM
                        casu_empresa
                    ORDER BY
                        codigo_empresa DESC
                    LIMIT 1
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                
                $this->nomeEmpresa                      = $resultado['result'][0]['nome'];
                $this->cnpjEmpresa                      = $resultado['result'][0]['cnpj'];
                $this->cepEmpresa                       = $resultado['result'][0]['cep'];
                $this->ruaEmpresa                       = $resultado['result'][0]['rua'];
                $this->bairroEmpresa                    = $resultado['result'][0]['bairro'];
                $this->cidadeEmpresa                    = $resultado['result'][0]['cidade'];
                $this->estadoEmpresa                    = $resultado['result'][0]['uf'];
                $this->numeroEmpresa                    = $resultado['result'][0]['numero'];
                $this->telefoneEmpresa                  = $resultado['result'][0]['telefone'];
                $this->emailEmpresa                     = $resultado['result'][0]['email'];
                $this->inscricaoEstadualEmpresa         = $resultado['result'][0]['inscricao_estadual'];
                $this->tipoEmpresa                      = $resultado['result'][0]['tipo'];
                $this->dataSituacaoUfEmpresa            = $resultado['result'][0]['data_situacao_uf'];
                $this->situacaoCnpjEmpresa              = $resultado['result'][0]['situacao_cnpj'];
                $this->situacaoInscricaoEstadualEmpresa = $resultado['result'][0]['situacao_ie'];
                $this->cnaeEmpresa                      = $resultado['result'][0]['cnae_empresa'];
                $this->celularEmpresa                   = $resultado['result'][0]['celular_empresa'];
                $this->nomeLegivelEmpresa               = $resultado['result'][0]['nome_legivel'];
                $this->codigoEmpresa                    = $resultado['result'][0]['codigo_empresa'];
                
                return true;
            }
        }

        public function retornaUltimoCodigoTabela($tabela, $coluna){

            $sql = "SELECT
                        $coluna AS 'codigo'
                    FROM
                        $tabela
                    ORDER BY
                        $coluna DESC
                    LIMIT 1     
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function alteraDadosEmpresa($nome, $cnpj, $cep, $rua, $bairro, $cidade, $uf, $numero, $telefone, $email, $inscricao_estadual, $tipo, $data_situacao_uf, $situacao_cnpj, $situacao_ie, $cnae_empresa, $nome_legivel, $celular_empresa){

            if(!$data_situacao_uf){
                $data_situacao_uf = "NULL";
            }else{
                $data_situacao_uf = "'$data_situacao_uf'";
            }

            if(!$inscricao_estadual){
                $inscricao_estadual = "NULL";
            }else{
                $inscricao_estadual = "'$inscricao_estadual'";
            }

            if(!$tipo){
                $tipo = "NULL";
            }else{
                $tipo = "'$tipo'";
            }

            if(!$situacao_cnpj){
                $situacao_cnpj = "NULL";
            }else{
                $situacao_cnpj = "'$situacao_cnpj'";
            }

            if(!$situacao_ie){
                $situacao_ie = "NULL";
            }else{
                $situacao_ie = "'$situacao_ie'";
            }

            if(!$cnae_empresa){
                $cnae_empresa = "NULL";
            }else{
                $cnae_empresa = "'$cnae_empresa'";
            }

            if(!$celular_empresa){
                $celular_empresa = "NULL";
            }else{
                $celular_empresa = "'$celular_empresa'";
            }

            $sql        = "UPDATE casu_empresa SET nome = '$nome', cnpj = '$cnpj', cep = '$cep', rua = '$rua', bairro = '$bairro', cidade = '$cidade', uf = '$uf', numero = '$numero', telefone = '$telefone', email = '$email', inscricao_estadual = $inscricao_estadual, tipo = $tipo, data_situacao_uf = $data_situacao_uf, situacao_cnpj = $situacao_cnpj, situacao_ie = $situacao_ie, cnae_empresa = $cnae_empresa,nome_legivel = '$nome_legivel',  celular_empresa = $celular_empresa";
            
            $resultado  = $this->Consulta($sql);


            return true;
        }
        

    };

?>