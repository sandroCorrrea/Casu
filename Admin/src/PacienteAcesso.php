<?php

    class PacienteAcesso extends Casu{
        
        public $login;
        public $status;
        public $senha;
        public $codigo_paciente;

        public function __construct($codigo_paciente = NULL, $senha = NULL, $login = NULL, $status = NULL){

            $this->login            = $login;
            $this->status           = $status;
            $this->senha            = $senha;
            $this->codigo_paciente  = $codigo_paciente;
            
            return true;
        }

        public function insereUsuario(){

            $sqlSenhaUsuario    = "SELECT md5('$this->senha') AS senha";
            $resultadoSenha     = $this->Consulta($sqlSenhaUsuario);
            $hashSenha          = $resultadoSenha['result'][0]['senha'];

            $sql        = "INSERT INTO paciente_acesso (login, status, senha, codigo_paciente, data_criacao, data_ultima_atualizacao) VALUES ('$this->login','$this->status','$hashSenha', '$this->codigo_paciente', NOW(), NOW())";
            
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
                        pa.codigo_paciente
                    FROM
                        paciente_acesso AS pa
                    WHERE
                        pa.login = '$login'
                    AND
                        pa.senha = '$hashSenha'
                    AND
                        pa.status = 'ativo'
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