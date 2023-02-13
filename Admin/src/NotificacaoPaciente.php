<?php

    class NotificacaoPaciente extends Casu{
        
        public $promocoes;
        public $consultas;
        public $codigo_paciente;

        public function __construct($promocoes = NULL, $consultas = NULL, $codigo_paciente = NULL){

            $this->promocoes        = $promocoes;
            $this->consultas        = $consultas;
            $this->codigo_paciente  = $codigo_paciente;
            
            return true;
        }

        public function insereNotificacao(){
            
            $sql = "INSERT INTO paciente_notificacao (promocoes, consultas, codigo_paciente, data_criacao, data_ultima_alteracao) VALUES ('$this->promocoes', '$this->consultas', '$this->codigo_paciente', NOW(), NOW())";
            
            $resultado = $this->Consulta($sql);

            return true;
        }


    }
?>