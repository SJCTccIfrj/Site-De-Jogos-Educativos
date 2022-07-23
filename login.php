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
    <title>Login</title>
</head>
<body class="principal">
    <form id="conteudo" action="validarlogin.php" method="post">
        <a class="anterior" href="index.php"><img class="voltar" src="./img/back.png" alt=""></a>
        <h1>Login</h1>
        <input type="email" maxlength="50" size="30" name="email" placeholder="Email" required>
        <input type="password" maxlength="25" size="30" name="senha" placeholder="Senha" required>

        <input id="button" type="submit" value="Logar">
        <?php
        if(isset($_SESSION['invalido'])):
        ?>
        <div class="msg">
            <p>Email ou senha inválidos</p>
            <p>Ainda não se cadastrou?<a href="cadastro.php" style="color: blue;"> Clique aqui</a></p>
        </div>
        <?php
        endif;
        unset($_SESSION['invalido']);
        ?>
    </form>
</body>
</html>