<?php
session_start();
include("conexao.php");

$id_email = $_SESSION['id_email'];
$senha = mysqli_real_escape_string($mysqli, $_POST['senha']);

// Aqui é verificado se existe esse email e senha no banco de dados
// Se existir, retorna 1. Se não, retorna 0.
$query = "select * from usuarios where id_email = '$id_email' and senha = '$senha'";
$result = mysqli_query($mysqli, $query);
$row = mysqli_num_rows($result);
if ($row == 1){
    header('Location: atualizardados.php');
    exit;
}else{
    $_SESSION['incorreto'] = true;
    header('Location: meuperfil.php');
}
$mysqli->close();
exit;
?>