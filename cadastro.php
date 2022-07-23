<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro</title>
</head>
<body class="principal">
    <form id="conteudo" action="validarcadastro.php" method="post">
        <a class="anterior" href="index.php"><img class="voltar" src="./img/back.png" alt=""></a>
        <h1>Cadastro</h1>
        <input type="text" maxlength="50" size="30" name="nome" placeholder="Nome" required>
        <input type="text" maxlength="50" size="30" name="nick" placeholder="Nick" required>
        <input type="email" maxlength="50" size="30" name="email" placeholder="Email" required>
        <input type="password" maxlength="25" size="30" name="senha" placeholder="Senha" required>

        <input id="button" type="submit" value="Cadastrar">

        <?php
        if(isset($_SESSION['usuario_existe'])):
        ?>
        <div class="msg">
            <p>Usuário já cadastrado!</p>
            <p>Faça login <a href="login.php" style="color: blue;">aqui</a></p>
        </div>
        <?php
        endif;
        unset($_SESSION['usuario_existe']);
        ?>
    </form>
</body>
</html>