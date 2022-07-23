<?php
    session_start();
    include("conexao.php");
    if(empty($_SESSION['valido'])){
        $_SESSION['jgmemoria'] = true;
        header('Location: login.php');
        exit;
    } else {
        $email = $_SESSION['id_email'];
        $sql = "UPDATE usuarios SET ultimo_jogo = 'memoria' WHERE id_email = '$email'";
        $mysqli->query($sql);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylememoria.css">
    <title>Jogo da memória</title>
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
    
    <h2>Jogo da memória</h2>
    <div id="baralho"></div>
    <div id="mensagem"></div>
    <script src="memoria.js"></script>
</body>
</html>