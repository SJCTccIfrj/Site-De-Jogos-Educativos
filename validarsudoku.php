<?php
session_start();
include("conexao.php");

$email = $_SESSION['id_email'];
$pontuacao = 150 - ($_GET['erros'] * 5);
$temp = $_GET['seg'];
$seg = $temp%60;
$min = floor($temp/60);

if ($temp <= 30){$pontuacao += 50;}
elseif ($temp <= 60){$pontuacao += 40;}
elseif ($temp <= 120){$pontuacao += 30;}
elseif ($temp <= 180){$pontuacao += 20;}
elseif ($temp <= 300){$pontuacao += 10;}

$sql = "UPDATE usuarios SET pontuacao = pontuacao + '$pontuacao'  WHERE id_email = '$email'";
$mysqli->query($sql);

$sql = "SELECT minutos, segundos, partidas FROM sudoku WhERE usuario = '$email'";
$pesq = $mysqli->query($sql);
$dados = $pesq->fetch_assoc();

if ($dados['partidas'] == 0){
    $sql = "UPDATE sudoku SET pontuacao = pontuacao + '$pontuacao', minutos = '$min', segundos = '$seg', partidas = partidas+1 WHERE usuario = '$email'";
} else {
    if ($min < $dados['minutos']){
        $sql = "UPDATE sudoku SET pontuacao = pontuacao + '$pontuacao', minutos = '$min', segundos = '$seg', partidas = partidas+1 WHERE usuario = '$email'";
    } elseif ($min == $dados['minutos']){
        if ($seg < $dados['segundos']){
            $sql = "UPDATE sudoku SET pontuacao = pontuacao + '$pontuacao', minutos = '$min', segundos = '$seg', partidas = partidas+1 WHERE usuario = '$email'";    
        } else{
            $sql = "UPDATE sudoku SET pontuacao = pontuacao + '$pontuacao', partidas = partidas+1 WHERE usuario = '$email'";
        }
    } else{
        $sql = "UPDATE sudoku SET pontuacao = pontuacao + '$pontuacao', partidas = partidas+1 WHERE usuario = '$email'";
    }
}

$mysqli->query($sql);
$mysqli->close();

header('Location: sudoku.php');
?>