<?php

    class PessoaAcesso extends Casu{
        
        public $codigo_pessoa;
        public $senha;
        public $login;

        public function __construct($codigo_pessoa = NULL, $senha = NULL, $login = NULL){

            $this->codigo_pessoa    = $codigo_pessoa;
            $this->senha            = $senha;
            $this->login            = $login;
            
            return true;
        }

        public function insereUsuario(){

            $sqlSenhaUsuario    = "SELECT md5('$this->senha') AS senha";
            $resultadoSenha     = $this->Consulta($sqlSenhaUsuario);
            $hashSenha          = $resultadoSenha['result'][0]['senha'];

            $sql        = "INSERT INTO pessoa_acesso (codigo_pessoa, senha, login, data_criacao, data_ultima_alteracao) VALUES ('$this->codigo_pessoa', '$hashSenha', '$this->login', NOW(), NOW())";
            
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function verificaAcessoUsuario($login, $senha){

            // Vamos gerar o hash da senha para comparar com a salva no banco de dados.
            $sqlSenha   = "SELECT md5('$senha') AS senha";
            $resultado  = $this->Consulta($sqlSenha);

            // Hash da senha
            $hashSenha  = $resultado['result'];
            $hashSenha  = $hashSenha[0]['senha'];

            // Vamos verificar se o dados informados estão de acordo com os dados salvos no banco.
            $sql = "SELECT
                        pa.codigo_pessoa
                    FROM
                        pessoa_acesso AS pa
                    WHERE
                        pa.login = '$login'
                    AND
                        pa.senha = '$hashSenha'
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


    }
?>