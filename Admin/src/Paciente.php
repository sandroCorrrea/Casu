<?php

    class Paciente extends Casu{
        
        public $nome;
        public $cpf;
        public $data_nascimento;
        public $email;
        public $telefone;
        public $celular;
        public $numero_identidade;
        public $orgao_expeditor_identidade;
        public $uf_identidade;
        public $codigo_endereco_paciente;

        public function __construct($nome = NULL, $cpf = NULL, $data_nascimento = NULL, $email = NULL, $telefone = NULL, $celular = NULL, $numero_identidade = NULL, $orgao_expeditor_identidade = NULL, $uf_identidade = NULL, $codigo_endereco_paciente = NULL){

            $this->nome                         = $nome;
            $this->cpf                          = $cpf;
            $this->data_nascimento              = $data_nascimento;
            $this->email                        = $email;
            $this->telefone                     = $telefone;
            $this->celular                      = $celular;
            $this->numero_identidade            = $numero_identidade;
            $this->orgao_expeditor_identidade   = $orgao_expeditor_identidade;
            $this->uf_identidade                = $uf_identidade;
            $this->codigo_endereco_paciente     = $codigo_endereco_paciente;
            
            return true;
        }

        public function inserePaciente(){

            if(!$this->telefone){
                $this->telefone = "NULL";
            }else{
                $this->telefone = "'$this->telefone'";
            }
            
            $sql = "INSERT INTO paciente (nome, cpf, data_nascimento, email, telefone, celular, numero_identidade, orgao_expeditor_identidade, uf_identidade, codigo_endereco_paciente, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', '$this->cpf', '$this->data_nascimento', '$this->email', $this->telefone, '$this->celular', '$this->numero_identidade', '$this->orgao_expeditor_identidade', '$this->uf_identidade', '$this->codigo_endereco_paciente', NOW(), NOW())";
            
            $resultado = $this->Consulta($sql);

            return true;
        }

        public function verificaPacienteExistente($cpf, $email){

            $sql = "SELECT * FROM paciente WHERE cpf = '$cpf' AND email = '$email'";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return true;
            }else{
                return false;
            }
        }

        public function retornaTodosDadosDoPaciente($codigo_paciente){

            if($codigo_paciente == NULL){
                $subSql = "ORDER BY p.nome";
            }else{
                $subSql = "WHERE p.codigo_paciente = '$codigo_paciente'";
            }

            $sql = "SELECT
                        p.nome                          AS 'nome_paciente',
                        p.cpf                           AS 'cpf_paciente',
                        p.email                         AS 'login_paciente',
                        pe.codigo_endereco_paciente     AS 'codigo_endereco',
                        pn.promocoes                    AS 'notificacoes_promocoes',
                        pn.consultas                    AS 'notificacoes_consultas',
                        p.telefone,
                        p.celular,
                        p.data_nascimento,
                        p.numero_identidade,
                        p.uf_identidade,
                        p.orgao_expeditor_identidade,
                        pe.cep,
                        pe.bairro,
                        pe.localidade,
                        pe.logradouro,
                        pe.complemento,
                        pe.ibge,
                        pe.ddd,
                        pe.siafi,
                        DATE_FORMAT(p.data_criacao, '%d/%m/%Y ás %H:%i') AS 'data_criacao_paciente',
                        DATE_FORMAT(p.data_ultima_alteracao, '%d/%m/%Y ás %H:%i') AS 'data_atualizacao_paciente',
                        DATE_FORMAT(p.data_nascimento, '%d/%m/%Y') AS 'data_nascimento_formatado'
                    FROM
                        paciente AS p
                    INNER JOIN
                        paciente_endereco AS pe ON pe.codigo_endereco_paciente = p.codigo_endereco_paciente
                    INNER JOIN
                        paciente_notificacao AS pn ON pn.codigo_paciente = p.codigo_paciente
                    $subSql
                    
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function resetaSenhaPaciete($email){

            $sql = "SELECT * 
                    FROM 
                        paciente AS p
                    INNER JOIN
                        paciente_acesso AS pa ON pa.codigo_paciente = p.codigo_paciente
                    WHERE 
                        p.email = '$email' 
                    LIMIT 1
            ";
            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                // Vamos buscar pelo codigo do paciente seu acesso
                $codigoPessoa       = $resultado['result'][0]['codigo_paciente'];

                $sqlAtualizaSenha   = "SELECT codigo_acesso_paciente FROM paciente_acesso WHERE login = '$email' AND codigo_paciente = '$codigoPessoa'";
                $resultado          = $this->Consulta($sql);

                if($resultado['row'] <= 0){
                    return NULL;
                }else{
                    
                    $codigoUsuario      = $resultado['result'][0]['codigo_acesso_paciente'];
                    $senha              = generateRandomString();

                    $sql                = "UPDATE paciente_acesso SET senha = md5('$senha'), data_ultima_atualizacao = NOW() WHERE codigo_acesso_paciente = '$codigoUsuario'";
                    $resultado          = $this->Consulta($sql);

                    return $senha;
                }
            }
        }

    }
?>