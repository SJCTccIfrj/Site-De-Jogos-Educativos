<?php
session_start();
include("conexao.php");
if (isset($_SESSION['valido'])){
    $email = $_SESSION['id_email'];
    $sql = "UPDATE usuarios SET ultimo_jogo = 'velha2' WHERE id_email = '$email'";
    $mysqli->query($sql);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylejv.css">
    <title>JOGO DA VELHA(2 JOGADORES)</title>
</head>

<body>
    <input type="checkbox" id="check">
    <label for="check">
        <img class="imgmenu" src="./img/menu.png" alt="">
    </label>
    <nav>
        <ul>
            <li><a href="index.php"><img class="imgs" src="./img/home.png" alt=""><p>Home</p></a></li>
        </ul>
    </nav>
    <div id="tela-preta"></div>
    <div class="container">
        <h2>Jogo da velha</h2>
        <div class="grid">
            <div class="celula" id="0"></div>
            <div class="celula" id="1"></div>
            <div class="celula" id="2"></div>
            <div class="celula" id="3"></div>
            <div class="celula" id="4"></div>
            <div class="celula" id="5"></div>
            <div class="celula" id="6"></div>
            <div class="celula" id="7"></div>
            <div class="celula" id="8"></div>
        </div>
    </div>

    <script src="script2jog.js"></script>
</body>

</html>