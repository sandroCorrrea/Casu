<?php

    class Solicitacoes extends Casu{
        
        public function listaTodasSolicitacoes(){
            
            $sql = "SELECT
                        DATE_FORMAT(pa.data_criacao, '%d/%m/%Y ás %H:%i')   AS 'data_solicitacao',
                        p.nome                                              AS 'nome_paciente',
                        a.nome                                              AS 'nome_agendamento',
                        sc.nome                                             AS 'nome_categoria',
                        pa.status                                           AS 'status',
                        pa.codigo_paciente_consulta                         AS 'codigo'
                    FROM
                        paciente_agendamento AS pa
                    INNER JOIN
                        paciente AS p ON p.codigo_paciente = pa.codigo_paciente
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pa.codigo_agendamento
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria_tipo = a.codigo_servico_categoria_tipo
                    INNER JOIN
                        servico_categoria AS sc ON sc.codigo_servico_categoria = sct.codigo_servico_categoria
                    ORDER BY
                        pa.status
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function atualizaStatusSolicitacao($codigo_paciente_consulta, $status){

            $sql        = "UPDATE paciente_agendamento SET status = '$status' WHERE codigo_paciente_consulta = '$codigo_paciente_consulta'";
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function listaQuantidadeSolicitacoesPendentes($status = "analise"){

            $sql = "SELECT 
                        DATE_FORMAT(pa.data_criacao, '%d/%m/%Y ás %H:%i')   AS 'data_solicitacao',
                        a.nome                                              AS 'nome_agendamento',
                        p.nome                                              AS 'nome_paciente',
                        pa.codigo_paciente_consulta                         AS 'codigo_paciente_consulta'
                    FROM
                        paciente_agendamento AS pa
                    INNER JOIN
                        paciente AS p ON p.codigo_paciente = pa.codigo_paciente
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pa.codigo_agendamento
                    WHERE
                        pa.status = '$status'
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return 0;
            }else{
                return $resultado['result'];
            }
        }

    }
?>