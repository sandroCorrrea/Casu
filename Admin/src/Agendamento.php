<?php

    class Agendamento extends Conexao {

        public $nome;
        public $data;
        public $hora;
        public $codigo_pessoa;
        public $local;
        public $vagas;
        public $codigo_servico_categoria;
        public $valor;

        public function __construct($nome = NULL, $data = NULL, $hora = NULL, $codigo_pessoa = NULL, $local = NULL, $vagas = NULL, $codigo_servico_categoria = NULL, $valor = NULL){

            $this->nome                     = $nome;
            $this->data                     = $data;
            $this->hora                     = $hora;
            $this->codigo_pessoa            = $codigo_pessoa;
            $this->local                    = $local;
            $this->vagas                    = $vagas;
            $this->codigo_servico_categoria = $codigo_servico_categoria;
            $this->valor                    = $valor;

            return true;

        }

        public function insereAgendamento(){

            $this->valor = str_replace(",", ".", $this->valor);

            $sql        = "INSERT INTO agendamento(nome, data, hora, codigo_pessoa, local, vagas, codigo_servico_categoria_tipo, valor, data_criacao, data_ultima_atualizacao)VALUES ('$this->nome', '$this->data', '$this->hora', '$this->codigo_pessoa', '$this->local', '$this->vagas', '$this->codigo_servico_categoria', '$this->valor', NOW(), NOW())";
            
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function editarAgendamento($codigo_agendamento, $nome, $hora, $data, $codigo_pessoa, $local, $vagas, $codigo_servico_categoria_tipo, $valor){

            $valor  = str_replace(",", ".", $valor);
            
            $sql = "UPDATE agendamento SET nome = '$nome', data = '$data', hora = '$hora', codigo_pessoa = '$codigo_pessoa', local = '$local', vagas = '$vagas', codigo_servico_categoria_tipo = '$codigo_servico_categoria_tipo', valor = '$valor', data_ultima_atualizacao = NOW() WHERE codigo_agendamento = '$codigo_agendamento'";

            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function excluirAgendamento($codigoAgendamento){
            
            $sql        = "DELETE FROM agendamento WHERE codigo_agendamento = '$codigoAgendamento'";
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function todosAgendamentos($codigo_agendamento = NULL){
            
            if($codigo_agendamento){
                $subSql = "WHERE a.codigo_agendamento = '$codigo_agendamento' ORDER BY a.codigo_agendamento DESC";
            }else{
                $subSql = "ORDER BY a.codigo_agendamento DESC";
            }


            $sql = "SELECT
                        a.nome                                                      AS  'nome_agendamento',
                        p.nome                                                      AS  'nome_pessoa',
                        sc.nome                                                     AS  'nome_categoria',
                        CONCAT(DATE_FORMAT(a.data, '%d/%m/%Y'), ' ás ', a.hora)     AS 'horario_consulta',
                        sc.codigo_servico_categoria                                 AS 'codigo_categoria',
                        a.data,
                        a.hora,
                        a.codigo_pessoa,
                        a.vagas,
                        a.local,
                        a.codigo_agendamento,
                        sc.status,
                        DATE_FORMAT(a.data_criacao, '%d/%m/%Y ás %H:%i')            AS 'data_criacao_agendamento',
                        DATE_FORMAT(a.data, '%d/%m/%Y')                             AS 'data_formatada',
                        sct.nome                                                    AS 'sub_categoria',
                        sct.codigo_servico_categoria_tipo                           AS 'codigo_sub_categoria',
                        a.valor                                                     AS 'valor'
                    FROM
                        agendamento AS a
                    INNER JOIN
                        pessoa AS p ON p.codigo_pessoa = a.codigo_pessoa
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria_tipo = a.codigo_servico_categoria_tipo
                    INNER JOIN
                        servico_categoria AS sc ON sc.codigo_servico_categoria = sct.codigo_servico_categoria
                    $subSql
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaQuantidadeAgendamentoMes($mes){

            if($mes){
                $subSql = "WHERE DATE_FORMAT(a.data_criacao, '%m') = '$mes'";
            }else{
                $subSql = "";
            }
            
            $sql = "SELECT 
                        COUNT(a.codigo_agendamento) AS 'quantidade'
                    FROM
                        agendamento AS a
                    $subSql
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
            
        }

        public function atualizaNumeroDeVagasAgendamento($codigo_agendamento){
            
            $sql        = "UPDATE agendamento SET vagas = vagas - 1 WHERE codigo_agendamento = '$codigo_agendamento'";
            $resultado  = $this->Consulta($sql);

            return true;
        }

        public function retornaTodosAgendamentosPorCategoria($codigo_categoria){

            $sql = "SELECT
                        a.nome,
                        a.hora,
                        a.data,
                        DATE_FORMAT(a.data, '%d/%m/%Y') AS 'data_formatada',
                        a.vagas,
                        a.codigo_servico_categoria_tipo,
                        a.codigo_agendamento,
                        a.local,
                        REPLACE(a.valor, '.', ',')      AS 'valor'
                    FROM
                        servico_categoria AS sc
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria = sc.codigo_servico_categoria
                    INNER JOIN
                        agendamento AS a ON a.codigo_servico_categoria_tipo = sct.codigo_servico_categoria_tipo
                    WHERE
                        sct.codigo_servico_categoria_tipo = '$codigo_categoria'
                    ORDER BY
                        a.data DESC
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaTodosAgendamentosPorPeriodo($periodo = NULL, $dia = NULL, $mes = NULL, $dataInicio = NULL, $dataFim = NULL, $categoria = NULL){
            
            if($periodo == "mes"){

                $subSql = "WHERE 
                    DATE_FORMAT(a.data, '%m') = '$mes'
                ";

                $subSqlSoma = "WHERE 
                    DATE_FORMAT(age.data, '%m') = '$mes'
                ";

            }else if($periodo == "dia"){

                $subSql = "WHERE 
                        DATE_FORMAT(a.data, '%d') = '$dia'
                ";

                $subSqlSoma = "WHERE 
                        DATE_FORMAT(age.data, '%d') = '$dia'
                ";

            }else if($dataInicio && $dataFim && $categoria){

                $subSql = " WHERE 
                                a.data >= CAST('$dataInicio' AS DATE)
                            AND 
                                a.data <= CAST('$dataFim' AS DATE)
                            AND
                                sct.codigo_servico_categoria_tipo = '$categoria'
                ";

                $subSqlSoma = " WHERE 
                                age.data >= CAST('$dataInicio' AS DATE)
                            AND 
                                age.data <= CAST('$dataFim' AS DATE)
                            AND
                                ser_cat_tip.codigo_servico_categoria_tipo = '$categoria'
                ";
                
            }else if($dataInicio && $dataFim){

                $subSql = " WHERE 
                                a.data >= CAST('$dataInicio' AS DATE)
                            AND 
                                a.data <= CAST('$dataFim' AS DATE)
                ";

                $subSqlSoma = " WHERE 
                                age.data >= CAST('$dataInicio' AS DATE)
                            AND 
                                age.data <= CAST('$dataFim' AS DATE)
                ";

            }else if($dataInicio){
                
                $subSql = "WHERE 
                            a.data >= CAST('$dataInicio' AS DATE)
                ";

                $subSqlSoma = "WHERE 
                            age.data >= CAST('$dataInicio' AS DATE)
                ";

            }else if($dataFim){

                $subSql = "WHERE 
                            a.data <= CAST('$dataFim' AS DATE)
                ";

                $subSqlSoma = "WHERE 
                            age.data <= CAST('$dataFim' AS DATE)
                ";

            }else if($categoria){
                $subSql = "WHERE 
                    sct.codigo_servico_categoria_tipo = '$categoria'
                ";

                $subSqlSoma = "WHERE 
                    ser_cat_tip.codigo_servico_categoria_tipo = '$categoria'
                ";
            }else{
                
                $subSql = "";

                $subSqlSoma = "";

            }


            $sql = "SELECT
                        DATE_FORMAT(a.data, '%d/%m/%Y')             AS 'data_agendamento',
                        a.nome                                      AS 'nome_agendamento',
                        p.nome                                      AS 'nome_paciente',
                        CONCAT('R$ ', REPLACE(a.valor, '.', ','))   AS 'valor',
                        CONCAT(sc.nome, ' - ', sct.nome)            AS 'categoria_formatada',
                        pa.status                                   AS 'status',
                        (
                            SELECT 
                                REPLACE(SUM(age.valor), '.', ',') AS 'valor'
                            FROM 
                                paciente_agendamento AS pac_age
                            INNER JOIN
                                agendamento AS age ON age.codigo_agendamento = pac_age.codigo_agendamento
                            INNER JOIN
                                servico_categoria_tipo AS ser_cat_tip ON ser_cat_tip.codigo_servico_categoria_tipo = age.codigo_servico_categoria_tipo
                            INNER JOIN
                                servico_categoria AS ser_cat ON ser_cat.codigo_servico_categoria = ser_cat_tip.codigo_servico_categoria
                            $subSqlSoma
                        ) AS 'valor_agendamento'
                    FROM
                        paciente_agendamento AS pa
                    INNER JOIN
                        agendamento AS a ON pa.codigo_agendamento = a.codigo_agendamento
                    INNER JOIN
                        paciente AS p ON p.codigo_paciente = pa.codigo_paciente
                    INNER JOIN
                        servico_categoria_tipo AS sct ON sct.codigo_servico_categoria_tipo = a.codigo_servico_categoria_tipo
                    INNER JOIN
                        servico_categoria AS sc ON sc.codigo_servico_categoria = sct.codigo_servico_categoria
                    $subSql
                    ORDER BY
                        pa.status ASC,
                        a.data DESC
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaQuantidadeDeAgendamentosFinalizados(){

            $dataDeHoje = date('Y-m-d');

            $sql = "SELECT
                        COUNT(a.codigo_agendamento)                                     AS 'finalizados',
                        (SELECT COUNT(ag.codigo_agendamento) FROM agendamento AS ag)    AS 'total'
                    FROM
                        agendamento AS a
                    WHERE
                        a.data < CAST('$dataDeHoje' AS DATE)
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'][0];
            }
        }

        public function retornaAgendamentosAgrupadosPorMes($mes){
            
            $sql = "SELECT
                        count(a.codigo_agendamento) AS 'quantidade'
                    FROM 
                        paciente_agendamento AS pa
                    INNER JOIN 
                        agendamento AS a ON a.codigo_agendamento = pa.codigo_agendamento 
                    WHERE 
                        date_format(a.data, '%m') = '$mes'
            ";

            $resultado = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return 0;
            }else{
                return $resultado['result'][0]['quantidade'];
            }
        }

        public function pesquisaAgendamentoPorNome($nome){
            
            $sql = "SELECT
                        a.nome,
                        a.codigo_agendamento,
                        DATE_FORMAT(a.data, '%d/%m/%Y') AS 'data'
                    FROM
                        agendamento AS a
                    WHERE
                        nome LIKE '$nome%'
                    LIMIT 
                        20
            ";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return NULL;
            }else{
                return $resultado['result'];
            }
        }

        public function retornaTodasConsultaDoPacientePorNome($codigo_paciente, $nome){
            
            $sql = "SELECT
                        a.nome                          AS 'nome_agendamento',
                        DATE_FORMAT(a.data, '%d/%m/%Y') AS 'data_agendamento',
                        a.hora                          AS 'hora_agendamento',
                        a.local                         AS 'local_agendamento',
                        a.codigo_agendamento,
                        pc.status
                    FROM
                        paciente_agendamento AS pc
                    INNER JOIN
                        agendamento AS a ON a.codigo_agendamento = pc.codigo_agendamento
                    WHERE
                        pc.codigo_paciente = '$codigo_paciente'
                    AND
                        a.nome LIKE '$nome%'
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

        public function somaTotalAgendamentos(){
            
            $sql = "SELECT REPLACE(ROUND(SUM(a.valor),2), '.', ',') AS 'valor' FROM agendamento AS a";

            $resultado  = $this->Consulta($sql);

            if($resultado['row'] <= 0){
                return 0;
            }else{
                return $resultado['result'][0];
            }
        }
    };

?>