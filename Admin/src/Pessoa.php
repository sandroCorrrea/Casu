<?php

    class Pessoa extends Casu{
        
        public $nome;
        public $cpf;
        public $email;
        public $data_nascimento;
        public $estado_identidade;
        public $numero_identidade;
        public $codigo_endereco_pessoa;

        public function __construct($nome = NULL, $cpf = NULL, $email = NULL, $data_nascimento = NULL, $estado_identidade = NULL, $numero_identidade = NULL, $codigo_endereco_pessoa = NULL){

            $this->nome                     = $nome;
            $this->cpf                      = $cpf;
            $this->email                    = $email;
            $this->data_nascimento          = $data_nascimento;
            $this->estado_identidade        = $estado_identidade;
            $this->numero_identidade        = $numero_identidade;
            $this->codigo_endereco_pessoa   = $codigo_endereco_pessoa;
            
            return true;
        }

        public function inserePessoa(){
            
            $sql        = "INSERT INTO pessoa (nome, cpf, email, data_nascimento, estado_identidade, numero_identidade, codigo_endereco_pessoa, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', '$this->cpf', '$this->email', '$this->data_nascimento', '$this->estado_identidade', '$this->numero_identidade', '$this->codigo_endereco_pessoa', NOW(), NOW())";

            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function retornaTodosDadosDePessoa($codigo_pessoa){

            $sql = "SELECT
                        pa.codigo_pessoa            AS 'codigo_pessoa',
                        pa.login                    AS 'login',
                        p.codigo_endereco_pessoa    AS 'codigo_endereco',
                        g.codigo_grupo              AS 'codigo_grupo',
                        g.nome                      AS 'nome_grupo',
                        p.nome                      AS 'nome_pessoa'
                    FROM
                        pessoa_acesso AS pa
                    INNER JOIN
                        pessoa AS p ON p.codigo_pessoa = pa.codigo_pessoa
                    INNER JOIN
                        pessoa_grupo AS pg ON pg.codigo_pessoa = p.codigo_pessoa
                    INNER JOIN
                        grupo AS g ON g.codigo_grupo = pg.codigo_grupo
                    WHERE
                        pa.codigo_pessoa = '$codigo_pessoa'
            ";

            $resultado  = $this->Consulta($sql);

            // OS DADOS ESTÃO INCORRETOS
            if($resultado['row'] <= 0){
                return false;
            }else{
                // OS DADOS ESTÃO CORRETOS
                return $resultado['result'];
            }
        }

        public function retornaTodosDadosDaPessoaEndereco($codigo_pessoa){
            
            $sql = "SELECT
                        p.*,
                        ae.*,
                        DATE_FORMAT(p.data_criacao, '%d/%m/%Y ás %H:%i') AS 'data_criacao_formatada',
                        DATE_FORMAT(p.data_ultima_alteracao, '%d/%m/%Y ás %H:%i') AS 'data_alteracao_formatada'
                    FROM
                        pessoa AS p
                    INNER JOIN
                        pessoa_endereco AS ae ON ae.codigo_endereco_pessoa = p.codigo_endereco_pessoa
                    WHERE
                        p.codigo_pessoa = '$codigo_pessoa'
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function alteraDadosDaPessoa($nome, $cpf, $email, $data_nascimento, $estado_identidade, $numero_identidade, $codigo_pessoa){
            
            $sql        = "UPDATE pessoa SET nome = '$nome', cpf = '$cpf', email = '$email', data_nascimento = '$data_nascimento', estado_identidade = '$estado_identidade', numero_identidade = '$numero_identidade', data_ultima_alteracao = NOW() WHERE codigo_pessoa = '$codigo_pessoa'";
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function alteraSenhaPessoa($email){

            $sql = "SELECT
                        pa.codigo_pessoa_acesso
                    FROM
                        pessoa AS p
                    INNER JOIN
                        pessoa_acesso AS pa ON pa.codigo_pessoa = p.codigo_pessoa
                    WHERE
                        p.email = '$email'
                    AND
                        pa.login = '$email'
                    LIMIT 
                        1
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                $dadosPessoa    = $resultado['result'][0]['codigo_pessoa_acesso'];
                $novaSenha      = generateRandomString();

                $sql        = "UPDATE pessoa_acesso SET senha = md5('$novaSenha') WHERE codigo_pessoa_acesso = '$dadosPessoa'";
                $resultado  = $this->Consulta($sql);
                
                return $novaSenha;
            }
        }


    }
?>