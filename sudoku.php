<?php
    session_start();
    include("conexao.php");

    if(empty($_SESSION['valido'])){
        $_SESSION['sudoku'] = true;
        header('Location: login.php');
        exit;
    } else {
        $email = $_SESSION['id_email'];
        $sql = "UPDATE usuarios SET ultimo_jogo = 'sudoku' WHERE id_email = '$email'";
        $mysqli->query($sql);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="widht=device-widht initial-scale=1.0 scalable=no">
        <title>Sudoku</title>

        <link rel="stylesheet" href="sudoku.css">
        <script src="sudoku.js"></script>
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
        
        <section>
            <h1>Sudoku</h1>
            <hr>
            <div id = "baralho">
            <div id="aa"><h2 id="errors">0</h2></div>
            
            
            <div id="placa"></div>
            <br>
            <div id="valeu"></div>
            </div>
        </section>
    </body>
</html>