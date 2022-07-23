<?php

    $hostname = "localhost";
    $bancodedados = "tcc";
    $usuario = "root";
    $senha = "";

    $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados, 3307);
    if ($mysqli -> connect_errno){
        echo "Falha ao conectar (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
?>