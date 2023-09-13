<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $dbname = "rede_social";

    $conexao = mysqli_connect($server, $user, $password, $dbname);
    if(!$conexao){
        die("Houve um erro: " . mysqli_connect_error());
    }
?>