<?php

    class ServicoCategoria extends Casu{
        
        public $nome;
        public $descricao;
        public $status;

        public function __construct($nome = NULL, $descricao = NULL, $status = NULL){

            $this->nome         = $nome;
            $this->descricao    = $descricao;
            $this->status       = $status;
            
            return true;
        }

        public function insereServicoCategoria(){

            if($this->descricao){
                $sql        = "INSERT INTO servico_categoria (nome, descricao, status, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', '$this->descricao', '$this->status', NOW(), NOW())";
            }else{
                $sql        = "INSERT INTO servico_categoria (nome, descricao, status, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', NULL, '$this->status', NOW(), NOW())";
            }
            
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function listaTodasCategorias($status = "ativa"){

            if($status == "todas"){
                $subSql = "";
            }else{
                $subSql = "WHERE sc.status   = '$status'";
            }
            
            $sql = "SELECT
                        sc.nome,
                        sc.descricao,
                        sc.status,
                        sc.data_criacao,
                        sc.data_ultima_alteracao,
                        sc.codigo_servico_categoria
                    FROM
                        servico_categoria AS sc
                    $subSql
                    ORDER BY
                        sc.nome
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function alteraCategoria($codigo_servico_categoria, $nome, $descricao, $status){

            if($descricao){
                $sql        = "UPDATE servico_categoria SET nome = '$nome', descricao = '$descricao', status = '$status', data_ultima_alteracao = NOW() WHERE codigo_servico_categoria = '$codigo_servico_categoria'";
            }else{
                $sql        = "UPDATE servico_categoria SET nome = '$nome', descricao = NULL, status = '$status', data_ultima_alteracao = NOW() WHERE codigo_servico_categoria = '$codigo_servico_categoria'";
            }

            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function listaCategoriasRecentes(){
            
            $sql = "SELECT
                        sc.nome,
                        sc.descricao,
                        sc.status,
                        sc.data_criacao,
                        sc.data_ultima_alteracao,
                        sc.codigo_servico_categoria
                    FROM
                        servico_categoria AS sc
                    WHERE
                        sc.status = 'ativa'
                    ORDER BY
                        sc.data_criacao DESC
                    LIMIT 3
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function quantidadeDeCategorias($status = "ativa"){
            
            $sql = "SELECT
                        COUNT(sc.codigo_servico_categoria) AS 'quantidade',
                        sc.nome
                    FROM
                        servico_categoria AS sc
                    WHERE
                        sc.status   = '$status'
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return 0;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaQuantidadeDeAgendamentosCategorias($codigo_servico_categoria){

            $sql = "SELECT
                        COUNT(a.codigo_agendamento) AS 'quantidade',
                        sc.nome
                    FROM
                        servico_categoria AS sc
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria = sc.codigo_servico_categoria
                    INNER JOIN
                        agendamento AS a ON a.codigo_servico_categoria_tipo = sct.codigo_servico_categoria_tipo
                    WHERE
                        sc.codigo_servico_categoria = '$codigo_servico_categoria'
            ";  

            $resultado = $this->Consulta($sql);

            if($resultado <= 0){
                return 0;
            }else{
                return $resultado['result'][0];
            }
        }

        public function retornaDadosDaCategoria($codigo_servico_categoria){
            
            $sql = "SELECT *
                    FROM    
                        servico_categoria AS sc
                    WHERE
                        sc.codigo_servico_categoria = '$codigo_servico_categoria'
            ";

            $resultado = $this->Consulta($sql);

            if($resultado <= 0){
                return NULL;
            }else{
                return $resultado['result'][0];
            }
        }

    }
?>