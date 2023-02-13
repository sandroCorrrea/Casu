<?php

    class PacienteConsulta extends Casu{
        
        public $codigo_paciente;
        public $codigo_agendamento;

        public function __construct($codigo_paciente = NULL, $codigo_agendamento = NULL){

            $this->codigo_paciente      = $codigo_paciente;
            $this->codigo_agendamento   = $codigo_agendamento;
            
            return true;
        }

        public function inserePacienteConsulta(){
            
            $sql        = "INSERT INTO paciente_agendamento (codigo_paciente, codigo_agendamento, data_criacao, data_ultima_alteracao) VALUES ('$this->codigo_paciente', '$this->codigo_agendamento', NOW(), NOW())";

            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function retornaTodasConsultaDoPaciente($codigo_paciente, $codigo_consulta = NULL){

            if($codigo_consulta){
                $subSql = "AND a.codigo_agendamento = '$codigo_consulta'";
            }else{
                $subSql = "";
            }
            
            $sql = "SELECT
                        a.nome                          AS 'nome_agendamento',
                        DATE_FORMAT(a.data, '%d/%m/%Y') AS 'data_agendamento',
                        a.hora                          AS 'hora_agendamento',
                        a.local                         AS 'local_agendamento',
                        a.codigo_agendamento,
                        pc.status,
                        REPLACE(a.valor, '.', ',')      AS 'valor_agendamento'
                    FROM
                        paciente_agendamento AS pc
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pc.codigo_agendamento
                    WHERE
                        pc.codigo_paciente = '$codigo_paciente'
                    $subSql
                    ORDER BY
                        pc.status ASC, a.data DESC
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function verificaAgendamentoJaFeito($codigo_paciente, $codigo_agendamento){
        
            $sql = "SELECT *
                    FROM
                        paciente_agendamento AS pa
                    WHERE
                        pa.codigo_paciente = '$codigo_paciente'
                    AND
                        pa.codigo_agendamento = '$codigo_agendamento'
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return true;
            }else{
                return false;
            }
        }

        public function retornaConsultaDoPaciente($codigo_paciente, $codigo_agendamento){
            
            $sql = "SELECT
                        a.nome                                              AS 'nome_agendamento',
                        DATE_FORMAT(a.data, '%d/%m/%Y')                     AS 'data_agendamento',
                        a.hora                                              AS 'hora_agendamento',
                        a.local                                             AS 'local_agendamento',
                        a.codigo_agendamento,
                        DATE_FORMAT(pc.data_criacao, '%d/%m/%Y ás %H:%i')   AS 'data_criacao_agendamento_paciente',
                        pc.status
                    FROM
                        paciente_agendamento AS pc
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pc.codigo_agendamento
                    WHERE
                        pc.codigo_paciente = '$codigo_paciente'
                    AND
                        pc.codigo_agendamento = '$codigo_agendamento'
                    ORDER BY
                        pc.codigo_paciente_consulta DESC
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaTodasCategorias($codigo_paciente, $codigo_agendamento = NULL){

            if($codigo_agendamento){
                $subSql = "AND a.codigo_agendamento = '$codigo_agendamento'";
            }else{
                $subSql = "";
            }
            
            $sql = "SELECT
                        sct.codigo_servico_categoria_tipo   AS 'codigo_sub_categoria',  
                        sc.codigo_servico_categoria         AS 'codigo_categoria',        
                        sc.nome                             AS 'nome_categoria',
                        sct.nome                            AS 'nome_sub_categoria'
                    FROM
                        paciente_agendamento AS pa
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pa.codigo_agendamento
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria_tipo = a.codigo_servico_categoria_tipo
                    INNER JOIN  
                        servico_categoria AS sc ON sc.codigo_servico_categoria = sct.codigo_servico_categoria
                    WHERE
                        pa.codigo_paciente = '$codigo_paciente'
                    $subSql
                    GROUP BY
                        sc.codigo_servico_categoria,
                        sct.codigo_servico_categoria_tipo   
            " ;

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaConsultaDoPacientePorCategoria($codigo_paciente, $codigo_consulta = NULL, $categoria, $subCategoria){

            if($codigo_consulta){
                $subSql = "AND a.codigo_agendamento = '$codigo_consulta'";
            }else{
                $subSql = "";
            }
            
            $sql = "SELECT
                        a.nome                          AS 'nome_agendamento',
                        DATE_FORMAT(a.data, '%d/%m/%Y') AS 'data_agendamento',
                        a.hora                          AS 'hora_agendamento',
                        a.local                         AS 'local_agendamento',
                        a.codigo_agendamento,
                        pa.status,
                        REPLACE(a.valor, '.', ',')      AS 'valor_agendamento'
                    FROM
                        paciente_agendamento AS pa
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pa.codigo_agendamento
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria_tipo = a.codigo_servico_categoria_tipo
                    INNER JOIN
                        servico_categoria AS sc ON sc.codigo_servico_categoria = sct.codigo_servico_categoria
                    WHERE
                        sc.status = 'ativa'
                    AND
                        pa.codigo_paciente = '$codigo_paciente'
                    AND
                        sct.codigo_servico_categoria_tipo = '$subCategoria'
                    AND
                        sc.codigo_servico_categoria = '$categoria'
                    $subSql
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }


    }
?>