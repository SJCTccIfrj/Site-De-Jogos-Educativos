<?php
session_start();
include("conexao.php");

$email = $_SESSION['id_email'];
$pontuacao = $_GET['pontuacao'];
$min = $_GET['min'];
$seg = $_GET['seg'];

$sql = "UPDATE usuarios SET pontuacao = pontuacao + '$pontuacao'  WHERE id_email = '$email'";
$mysqli->query($sql);

$sql = "SELECT minutos, segundos, partidas FROM jogo_memoria WhERE usuario = '$email'";
$pesq = $mysqli->query($sql);
$dados = $pesq->fetch_assoc();

if ($dados['partidas'] == 0){
    $sql = "UPDATE jogo_memoria SET pontuacao = pontuacao + '$pontuacao', minutos = '$min', segundos = '$seg', partidas = partidas+1 WHERE usuario = '$email'";
} else {
    if ($min < $dados['minutos']){
        $sql = "UPDATE jogo_memoria SET pontuacao = pontuacao + '$pontuacao', minutos = '$min', segundos = '$seg', partidas = partidas+1 WHERE usuario = '$email'";
    } elseif ($min == $dados['minutos']){
        if ($seg < $dados['segundos']){
            $sql = "UPDATE jogo_memoria SET pontuacao = pontuacao + '$pontuacao', minutos = '$min', segundos = '$seg', partidas = partidas+1 WHERE usuario = '$email'";    
        } else{
            $sql = "UPDATE jogo_memoria SET pontuacao = pontuacao + '$pontuacao', partidas = partidas+1 WHERE usuario = '$email'";
        }
    } else{
        $sql = "UPDATE jogo_memoria SET pontuacao = pontuacao + '$pontuacao', partidas = partidas+1 WHERE usuario = '$email'";
    }
}

$mysqli->query($sql);
$mysqli->close();

header('Location: memoria.php');
?>