<?php
    session_start();
    include("conexao.php");

    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, $_POST['senha']);

    // Aqui é verificado se existe esse email e senha no banco de dados
    // Se existir, retorna 1. Se não, retorna 0.
    $query = "select * from usuarios where id_email = '$email' and senha = '$senha'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_num_rows($result);
    if ($row == 1){
        $_SESSION['valido'] = true;
        $_SESSION['id_email'] = $email;
        if ($_SESSION['jgvelha']){
            header('Location: jogadorvscomputador.php');
        }elseif ($_SESSION['jgmemoria']){
            header('Location: memoria.php');
        }elseif ($_SESSION['sudoku']){
            header('Location: sudoku.php');
        }else{
            header('Location: index.php');
        };
        exit;
    }else{
        $_SESSION['invalido'] = true;
        unset($SESSION['valido']);
        header('Location: login.php');
        exit;
    }

?>