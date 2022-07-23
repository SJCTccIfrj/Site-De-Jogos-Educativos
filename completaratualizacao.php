<?php
session_start();
include("conexao.php");
$id_email = $_SESSION['id_email'];
$sql="select * from usuarios where id_email= '$id_email'";
$pesq = $mysqli->query($sql);
$dados = $pesq->fetch_assoc();
$numc = $dados['num_cadastro'];

$extensao = strtolower(strrchr($_FILES['foto']['name'], '.'));
if (empty($extensao)){
    $endereco = $dados['ft_perfil'];
} else{
    $endereco = md5(time()) . $extensao;

    move_uploaded_file($_FILES['foto']['tmp_name'], "imgPerfil/".$endereco);
}

$nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
$nick = mysqli_real_escape_string($mysqli, trim($_POST['nick']));
$emailnovo = mysqli_real_escape_string($mysqli, trim($_POST['email']));
$senha = mysqli_real_escape_string($mysqli, trim($_POST['senha']));
if(empty($nome)){
    $nome = $dados['nome'];
}
if(empty($nick)){
    $nick = $dados['nick'];
}
if(empty($emailnovo)){
    $emailnovo = $id_email;
}
if(empty($senha)){
    $senha = $dados['senha'];
}

$sql = "update jogo_velha set usuario = '$emailnovo' where usuario = '$id_email'";
$mysqli->query($sql);

$sql = "update jogo_memoria set usuario = '$emailnovo' where usuario = '$id_email'";
$mysqli->query($sql);

$sql = "update usuarios set ft_perfil = '$endereco', id_email = '$emailnovo', senha = '$senha', nome = '$nome', nick = '$nick' where id_email = '$id_email';";
$mysqli->query($sql);
if(isset($id_email)){
    $_SESSION['atualizado'] = true;
}
$_SESSION['id_email'] = $emailnovo;
$mysqli->close();
header('Location: meuperfil.php');
exit;
?>