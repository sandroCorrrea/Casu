<?php

    function pr($str, $align = ''){
        echo "<pre" . ((!empty($align)) ? " align='$align'" : "") . ">";
        print_r($str);
        echo "</pre>";
    }

    function formataCpfParaBancoDeDados($cpf){

        $cpf    = str_replace(".", "", $cpf);
        $cpf    = str_replace("-", "", $cpf);

        return $cpf;
    }
    

    function verificaSessaoUsuario($logout = NULL){

        session_start();

        if($logout){
            session_destroy();
        }

        if(!isset($_SESSION['login'])){
            header("Location: ../view/");
            die;
        }
    }

    function mask($val, $mask){

        $maskared = '';

        $k = 0;

        for ($i = 0; $i <= strlen($mask) - 1; $i++) {

            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }

    function listaTodosDadosDaMatriz(){
        
        include_once '../src/Conexao.php';

        $conexao = new Conexao();

        $sql        = "SELECT * FROM casu_empresa";
        $resultado  = $conexao->Consulta($sql);

        if($resultado <= 0){
            return NULL;
        }else{
            return $resultado['result'];
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function random_color(){

        $hex = array_merge(range(0, 9), range('A', 'F'));

        $cor = '#';
        while(strlen($cor) < 7){
            $num = rand(0, 15);
            $cor .= $hex[$num];
        }

        return $cor;
    }

    function formataNumeroWpp($numero){
        
        // Vamos remover o 3º Número 9
        $ddd    = substr($numero, 0, 2);
        $numero = substr($numero, 3, 8);
        
        $numero = "55".$ddd.$numero;

        return $numero;
    }

    function retornaIpServidor(){

        exec("ipconfig /all", $output);

        foreach($output AS $key => $line){

            if($key == 46){
                $ip = explode(".", $line);

                foreach($ip AS $keyIp => $cadaCaracter){

                    if($cadaCaracter == "  : 192"){
                        pr($keyIp);
                        die;
                    }

                }
            }
        }

        return $ip;
    }

?>