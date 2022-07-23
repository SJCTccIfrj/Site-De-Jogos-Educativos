<?php
session_start();
include("conexao.php");

$email = $_SESSION['id_email'];
$sql = "UPDATE jogo_velha SET pontuacao = pontuacao+100, vitorias = vitorias+1, partidas = partidas+1 WHERE usuario = '$email'";
$mysqli->query($sql);
$sql = "UPDATE usuarios SET pontuacao = pontuacao+100  WHERE id_email = '$email'";
$mysqli->query($sql);
$mysqli->close();

header('Location: jogadorvscomputador.php');
?>