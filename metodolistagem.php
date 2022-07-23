<?php
    session_start();
    $_SESSION['lista'] = $_POST["listagem"];
    header('Location: lista.php');
    exit;
?>