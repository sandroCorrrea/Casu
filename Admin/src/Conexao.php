<?php

    class Conexao {

        public function conn(){

            $user = "b0aec228c5b6db";
            $pass = "c9bfea61";

            try {
                $dbh = new PDO('mysql:host=us-cdbr-east-06.cleardb.net;dbname=heroku_f9c257a64a49d8c', $user, $pass);
                return $dbh;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        
        public function Consulta($sql){

            $resultado          = $this->conn();
            $resultado          = $resultado->query($sql);
            $resultadoLinhas    = $resultado->rowCount();

            $dadosArray = array(
                "row"       => $resultadoLinhas,
                "result"    => $rows = $resultado->fetchAll(PDO::FETCH_ASSOC)
            );

            return $dadosArray;
        }

    };

?>