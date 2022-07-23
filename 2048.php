<?php
    session_start();
    include("conexao.php");
    if(empty($_SESSION['valido'])){
        $_SESSION['2048'] = true;
        header('Location: login.php');
        exit;
    } else {
        $email = $_SESSION['id_email'];
        $sql = "UPDATE usuarios SET ultimo_jogo = '2048' WHERE id_email = '$email'";
        $mysqli->query($sql);
    }
?>

<!DOCTYPE html>
<html>
 <head>
	<link rel="stylesheet" href="2048.css">
  <title>2048</title>
 </head>
 <body>
 	<input type="checkbox" id="check">
    <label for="check">
        <img class="imgmenu" src="./img/menu.png" alt="">
    </label>
    <nav>
        <ul>
            <li><a href="index.php"><img class="imgs" src="./img/home.png" alt=""><p>Home</p></a></li>
            <li><a href="lista.php"><img class="imgs" src="./img/ranking.png" alt=""><p>Ranking</p></a></li>
            <li><a href="sair.php"><img class="imgs" src="./img/sair.png" alt=""><p>Sair</p></a></li>
        </ul>
    </nav>

	<center>
    <div id="baralho">
	<div id="canvas"></div>
    </div>
	<h2 style="color: #fff;">Pontuação: <div style="display:inline; color: #fff" id="score"></div></h2>
    </center>
	<script src="2048.js"></script>
 </body>
</html>