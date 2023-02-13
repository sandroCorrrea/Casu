<?php

    class Grupo extends Casu{
        
        public $nome;
        public $descricao;

        public function __construct($nome = NULL, $descricao = NULL){

            $this->nome         = $nome;
            $this->descricao    = $descricao;
            
            return true;
        }

        public function insereGrupo(){

            if(!$this->descricao){
                $this->descricao = "NULL";
            }else{
                $this->descricao = "'$this->descricao'";
            }

            $sql        = "INSERT INTO grupo (nome, descricao, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', $this->descricao, NOW(), NOW())";
            
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function inserePessoaGrupo($codigo_pessoa, $codigo_grupo){

            $sql        = "INSERT INTO pessoa_grupo (codigo_pessoa, codigo_grupo, data_criacao, data_ultima_alteracao) VALUES ('$codigo_pessoa', '$codigo_grupo', NOW(), NOW())";
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function listaQuantidadeDePessoasNoGrupo($codigo_grupo){

            $sql = "SELECT
                        COUNT(pg.codigo_pessoa) AS 'quantidade'
                    FROM
                        pessoa_grupo AS pg
                    WHERE
                        codigo_grupo = '$codigo_grupo'
            ";
            
            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaTodosDadosDoGrupo($codigo_grupo){

            $sql = "SELECT
                        g.nome,
                        g.descricao,
                        DATE_FORMAT(g.data_criacao, '%d/%m/%Y ás %H:%i') AS 'data_criacao_grupo',
                        DATE_FORMAT(g.data_ultima_alteracao, '%d/%m/%Y ás %H:%i') AS 'data_ultima_alteracao_grupo',
                        p.nome AS 'nome_pessoa',
                        p.cpf,
                        p.email,
                        DATE_FORMAT(p.data_nascimento, '%d/%m/%Y') AS 'data_nascimento',
                        p.numero_identidade,
                        p.estado_identidade,
                        DATE_FORMAT(pg.data_criacao, '%d/%m/%Y ás %H:%i') AS 'data_vinculo'
                    FROM
                        grupo AS g
                    INNER JOIN
                        pessoa_grupo AS pg ON pg.codigo_grupo = g.codigo_grupo
                    INNER JOIN
                        pessoa AS p ON p.codigo_pessoa = pg.codigo_pessoa
                    WHERE
                        g.codigo_grupo = '$codigo_grupo'
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaTodosGruposCadastrados(){
            
            $sql = "SELECT
                        g.codigo_grupo,
                        g.nome,
                        g.descricao,
                        g.data_criacao,
                        g.data_ultima_alteracao,
                        DATE_FORMAT(g.data_criacao, '%d/%m/%Y ás %H:%i') AS 'data_criacao_formatada'
                    FROM
                        grupo AS g
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function alteraDadosDoGrupo($nomeGrupo, $descricaoGrupo, $codigo_grupo){
            
            $sql        = "UPDATE grupo SET nome = '$nomeGrupo', descricao = '$descricaoGrupo', data_ultima_alteracao = NOW() WHERE codigo_grupo = '$codigo_grupo'";
            
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function listaTodasPessoasDoGrupo($codigo_grupo){
            
            $sql = "SELECT
                        p.nome,
                        p.cpf
                    FROM
                        pessoa_grupo AS pg
                    INNER JOIN
                        pessoa AS p ON p.codigo_pessoa = pg.codigo_pessoa
                    WHERE
                        pg.codigo_grupo = '$codigo_grupo'
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

    }
?>