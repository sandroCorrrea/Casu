<?php

    class ServicoCategoriaTipo extends Casu{
        
        public $nome;
        public $descricao;
        public $codigo_servico_categoria;

        public function __construct($nome = NULL, $descricao = NULL, $codigo_servico_categoria = NULL){

            $this->nome                             = $nome;
            $this->descricao                        = $descricao;
            $this->codigo_servico_categoria         = $codigo_servico_categoria;
            
            return true;
        }

        public function insereServicoCategoria(){

            if($this->descricao){
                $sql        = "INSERT INTO servico_categoria_tipo (nome, descricao, codigo_servico_categoria, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', '$this->descricao', '$this->codigo_servico_categoria', NOW(), NOW())";
            }else{
                $sql        = "INSERT INTO servico_categoria_tipo (nome, descricao, codigo_servico_categoria, data_criacao, data_ultima_alteracao) VALUES ('$this->nome', NULL, '$this->codigo_servico_categoria', NOW(), NOW())";
            }
            
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function listaTodosTiposCategoria(){
            
            $sql = "SELECT
                        sct.nome,
                        sct.descricao,
                        sct.codigo_servico_categoria,
                        sc.nome AS 'nome_categoria',
                        sct.codigo_servico_categoria_tipo
                    FROM
                        servico_categoria_tipo AS sct
                    INNER JOIN
                        servico_categoria AS sc ON sc.codigo_servico_categoria = sct.codigo_servico_categoria
                    ORDER BY
                        sct.codigo_servico_categoria_tipo DESC
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function alteraTipoCategoria($codigo_servico_categoria_tipo, $nome, $descricao, $codigo_servico_categoria){

            if($descricao){
                $sql        = "UPDATE servico_categoria_tipo SET nome = '$nome', descricao = '$descricao', codigo_servico_categoria = '$codigo_servico_categoria', data_ultima_alteracao = NOW() WHERE codigo_servico_categoria_tipo = '$codigo_servico_categoria_tipo'";
            }else{
                $sql        = "UPDATE servico_categoria_tipo SET nome = '$nome', descricao = NULL, codigo_servico_categoria = '$codigo_servico_categoria', data_ultima_alteracao = NOW() WHERE codigo_servico_categoria_tipo = '$codigo_servico_categoria_tipo'";
            }

            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function retornaTodasSubCategoriasDeUmaCategoria($codigo_servico_categoria){

            $sql = "SELECT
                        sct.nome,
                        sct.codigo_servico_categoria_tipo
                    FROM
                        servico_categoria_tipo AS sct
                    WHERE
                        sct.codigo_servico_categoria = '$codigo_servico_categoria'
                    ORDER BY
                        sct.nome
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