<?php
session_start();
include('conexao.php');
if (empty($_SESSION['valido'])){
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="perfil.css">
    <title>Perfil</title>
</head>
<body>
    <header>
        <div class="cabecalho">
            <ul class="info">
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
        <h1>Perfil do usuário</h1>

        <?php
            if (isset($_SESSION['valido'])){
                $id_email = $_SESSION['id_email'];
                $sql="select * from usuarios where id_email= '$id_email'";
                $pesq = $mysqli->query($sql);
                $dados = $pesq->fetch_assoc();
            }
        ?>

        <div class="dados">
            <div>
                <?php echo "<img class='img' src=./imgPerfil/".$dados['ft_perfil'].">" ?> <br>
                <?php echo "<p class='nickname'>".$dados['nick']."</p>" ?> <br>
            </div>
            <div class="infos">
                <p class="sla"> <b>Nome:</b> 
                <?php echo $dados['nome'] ?> </p> 
                <p class="sla"> <b>Email:</b> 
                <?php echo $dados['id_email'] ?> </p> 
                <p class="sla"> <b>Senha:</b> 
                <span class="senha"> <?php echo $dados['senha'] ?> </span> </p> 
            </div>
        </div>
        
        <h3> Modificação de dados </h3>
        <p class="aviso"> Para modificar seus dados, informe sua senha atual </p>
        <form action="validarsenha.php" method="post">
            <input type="password" id="senha" name="senha" placeholder="Senha" required>
            <input class="button" type="submit" value="Confirmar">

            <?php
                if(isset($_SESSION['incorreto'])):
            ?>
            <div class="msg">
            <p>Senha incorreta</p>
            </div>
             <?php
                endif;
                unset($_SESSION['incorreto']);
            ?>
            <?php
                if(isset($_SESSION['atualizado'])):
            ?>
            <div class="msg">
            <p>Dados atualizados com sucesso</p>
            </div>
            <?php
                endif;
                unset($_SESSION['atualizado']);
            ?>
        </form>
    </main>
</body>
</html>