<?php
session_start();
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dados.css">
    <title>Atualização de dados</title>
</head>
<body>
    <header>
        <div class="cabecalho">
            <ul class="info">
                <?php
                    if(empty($_SESSION['valido'])):
                ?>
                <li class="menu"><a href="login.php">Logar</a></li>
                <li class="menu"><a href="cadastro.php">Cadastrar</a></li>
                <?php
                    endif
                ?>
                <?php
                    if(isset($_SESSION['valido'])):
                    $id_email = $_SESSION['id_email'];
                    $sql="select ft_perfil, nick from usuarios where id_email= '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $perfil = $pesq->fetch_assoc();
                ?>
                <div class="drop">
                    <li class="perfil2"><a href="index.php">Home</a></li>
                    <li class="perfil2"><a href="sair.php">Sair</a></li>
                    <li class="perfil2"><a class="inicio" href="lista.php">Ranking</a></li>
                </div>
                <?php
                    endif
                ?>
            </ul>

            <img class="logo" src="./img/JDC.png" alt=""> 
        </div>
    </header>

    <main class="conteiner">
        <form action="completaratualizacao.php" method="post" enctype="multipart/form-data">
            <h1>Atualize seus dados</h1>
            <p class="aviso">Não é necessário atualizar todos</p>
            <?php
                    if(isset($_SESSION['valido'])):
                    $id_email = $_SESSION['id_email'];
                    $sql="select ft_perfil from usuarios where id_email= '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $foto = $pesq->fetch_assoc();
            ?>
            <label for="foto">
                <?php echo "<img class='alterar' src=./imgPerfil/".$foto['ft_perfil'].">" ?>
            </label>
            <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png, .webp">
            <?php
                endif
            ?>

            <p class="mn">Nome</p>
            <input type="text" name="nome" placeholder="Nome">

            <p class="mn">Nick</p>
            <input type="text" name="nick" placeholder="Nick">

            <p class="mn">Email</p>
            <input type="email" name="email" placeholder="Email">

            <p class="mn">Senha</p>
            <input type="password" name="senha" placeholder="Senha">

            <input class="button" type="submit" value="Alterar">
        </form>
    </main>
</body>
</html>