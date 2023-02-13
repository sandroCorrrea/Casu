<?php

    class EnderecoPessoa extends Casu{
        
        public $cep;
        public $logradouro;
        public $complemento;
        public $bairro;
        public $localidade;
        public $uf;
        public $ibge;
        public $gia;
        public $ddd;
        public $siafi;

        public function __construct($cep = NULL, $logradouro = NULL, $complemento = NULL, $bairro = NULL, $localidade = NULL, $uf = NULL, $ibge = NULL, $gia = NULL, $ddd = NULL, $siafi = NULL){

            $this->cep          = $cep;
            $this->logradouro   = $logradouro;
            $this->complemento  = $complemento;
            $this->bairro       = $bairro;
            $this->localidade   = $localidade;
            $this->uf           = $uf;
            $this->ibge         = $ibge;
            $this->gia          = $gia;
            $this->ddd          = $ddd;
            $this->siafi        = $siafi;
            
            return true;
        }

        public function insereEndereco(){

            if(!$this->complemento){
                $this->complemento = "NULL";
            }

            if(!$this->gia){
                $this->gia = "NULL";
            }

            $sql        = "INSERT INTO pessoa_endereco (cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi, data_criacao, data_ultima_alteracao) VALUES ('$this->cep', '$this->logradouro', $this->complemento, '$this->bairro', '$this->localidade', '$this->uf', '$this->ibge', $this->gia, '$this->ddd', '$this->siafi', NOW(), NOW())";
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function alteraEndereco($codigo_endereco_pessoa, $cep, $logradouro, $complemento, $bairro, $localidade, $uf, $ibge, $gia, $ddd, $siafi){

            if(!$complemento){
                $complemento = "NULL";
            }else{
                $complemento = "'$complemento'";
            }

            if(!$gia){
                $gia = "NULL";
            }else{
                $gia    = "'$gia'";
            }

            $sql        = "UPDATE pessoa_endereco SET cep = '$cep', logradouro = '$logradouro', complemento = $complemento, bairro = '$bairro', localidade = '$localidade', uf = '$uf', ibge = '$ibge', gia = $gia, ddd = '$ddd', siafi = '$siafi', data_ultima_alteracao = NOW() WHERE codigo_endereco_pessoa = '$codigo_endereco_pessoa'";

            $resultado  = $this->Consulta($sql);

            return true;
        }


    }
?>