<?php
session_start();
include("conexao.php");

if (isset($_SESSION['valido'])){
    $email = $_SESSION['id_email'];
    $sql = "SELECT ultimo_jogo FROM usuarios WHERE id_email = '$email'";
    $pesq = $mysqli->query($sql);
    $jogo = $pesq->fetch_assoc();
    $jogo = $jogo['ultimo_jogo'];
}

if (isset($_GET['muda'])) {
    $jogo = $_GET['jogo'];
}
$sql = "SELECT id_email, nick, pontuacao FROM usuarios ORDER BY pontuacao DESC";
$con = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lista.css">
    <title>Ranking</title>
</head>
<body>
    <header>
        <div class="cabecalho">
            <ul class="info">
                <?php
                    if(empty($_SESSION['valido'])):
                ?>
                <li class="menu"><a class="inicio" href="login.php">Logar</a></li>
                <li class="menu"><a class="inicio" href="cadastro.php">Cadastrar</a></li>
                <?php
                    endif
                ?>
                <?php
                    if(isset($_SESSION['valido'])):
                    $id_email = $_SESSION['id_email'];
                    $sql="select nick, ft_perfil from usuarios where id_email= '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $perfil = $pesq->fetch_assoc();
                ?>
                <li class="perfil">
                    <a class="inicio" href="meuperfil.php">
                        <?php echo "<img class='imgperfil' src=./imgPerfil/".$perfil['ft_perfil'].">" ?>
                        <?php echo "<p class='nick'>".$perfil['nick']."</p>" ?>
                    </a>
                </li>
                <li class="perfil2"><a class="inicio" href="sair.php">Sair</a></li>
                <li class="perfil2"><a class="inicio" href="index.php">Home</a></li>
                <?php
                    endif
                ?>
            </ul>

            <img class="logo" src="./img/JDC.png" alt=""> 
        </div>
    </header>

    <main>
        <div class="rank">
            <!-- PONTUAÇÂO GERAL -->
            <section class="pontgeral">
                <div>
                    <img src="./img/trofeu.png" alt="">
                    <h1>Ranking geral</h1>
                </div>
                <table>
                    <tr class="esp">
                        <td>Classificação</td>
                        <td>Nick</td>
                        <td>Pontuação</td>
                    </tr>

                    <?php
                    $i = 1;
                    if (isset($_SESSION['valido'])):
                    $email = $_SESSION['id_email'];
                    while($dados = $con->fetch_array()){ 
                        if ($email != $dados['id_email']):
                    ?>

                    <tr class="dados">
                        <td><?php echo $i."º lugar" ?></td>
                        <?php $i++ ?>
                        <td><?php echo $dados["nick"] ?></td>
                        <td><?php echo $dados["pontuacao"] ?></td>
                    </tr>
                    <?php else: ?>
                    <tr class="meusdados">
                        <td><?php echo $i."º lugar" ?></td>
                        <?php $i++ ?>
                        <td><?php echo $dados["nick"] ?></td>
                        <td><?php echo $dados["pontuacao"] ?></td>
                    </tr>
                    <?php
                        endif;
                    }
                    else:
                        while($dados = $con->fetch_array()){
                    ?>
                    <tr class="dados">
                        <td><?php echo $i."º lugar" ?></td>
                        <?php $i++ ?>
                        <td><?php echo $dados["nick"] ?></td>
                        <td><?php echo $dados["pontuacao"] ?></td>
                    </tr>
                    <?php
                    } 
                    endif 
                    ?>
                </table>
                <!-- FIM PONTUAÇÂO GERAL -->
            </section>

            <?php
            if (isset($jogo)):
                if ($jogo == "velha" or $jogo == "velha2"):
            ?>
            <!-- JOGO DA VELHA -->
            <section class="jogos">
                <div>
                    <a href="lista.php?muda=true&jogo=2048"><img src="./img/esquerda.png" alt=""></a>
                    <h1>Jogo da velha</h1>
                    <a href="lista.php?muda=true&jogo=memoria"><img src="./img/direita.png" alt=""></a>
                </div>

                <section class="pont">
                    <?php
                    $sql = "SELECT usuario, pontuacao FROM jogo_velha ORDER BY pontuacao DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <thead>
                            <tr class="esp">
                                <td>Classificação</td>
                                <td>Nick</td>
                                <td>Pontuação</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($_SESSION['valido'])):
                                $email = $_SESSION['id_email'];
                                while ($dados = $con->fetch_array()){
                                    if ($email != $dados['usuario']):
                            ?>

                            <tr class="dados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"]
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>
                            <?php   else: ?>
                            <tr class="meusdados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"] 
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>

                            <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["pontuacao"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                        </tbody>    
                    </table>
                </section>

                <section class="vit">
                    <?php
                    $sql = "SELECT usuario, vitorias FROM jogo_velha ORDER BY vitorias DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Vitórias</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["vitorias"] ?></td>
                        </tr>
                        <?php   else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["vitorias"] ?></td>
                        </tr>

                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["vitorias"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                    </table>
                </section>

                <section class="part">
                    <?php
                    $sql = "SELECT usuario, partidas FROM jogo_velha ORDER BY partidas DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Partidas</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php   else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>

                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                    </table>
                </section>
            </section>
            <!-- FIM JOGO DA VELHA -->
            
            <?php 
                elseif ($jogo == "memoria"):
            ?>

            <!-- JOGO DA MEMORIA -->
            <section class="jogos">
                <div>
                    <a href="lista.php?muda=true&jogo=velha"><img src="./img/esquerda.png" alt=""></a>
                    <h1>Jogo da memoria</h1>
                    <a href="lista.php?muda=true&jogo=sudoku"><img src="./img/direita.png" alt=""></a>
                </div>

                <section class="pont">
                    <?php
                    $sql = "SELECT usuario, pontuacao FROM jogo_memoria ORDER BY pontuacao DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <thead>
                            <tr class="esp">
                                <td>Classificação</td>
                                <td>Nick</td>
                                <td>Pontuação</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($_SESSION['valido'])):
                                $email = $_SESSION['id_email'];
                                while ($dados = $con->fetch_array()){
                                    if ($email != $dados['usuario']):
                            ?>

                            <tr class="dados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"]
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>
                            <?php   else: ?>
                            <tr class="meusdados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"] 
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>

                            <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["pontuacao"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                        </tbody>    
                    </table>
                </section>

                <section class="tempo">
                    <?php
                    $sql = "SELECT usuario, concat(minutos, ' : ', segundos) as 'tempo', partidas FROM jogo_memoria ORDER BY minutos, segundos";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Tempo</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($dados['partidas'] != 0):
                                    if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>
                        <?php       else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>

                        <?php
                                    endif;
                                else:
                        ?>
                        <tr class="empty">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                                if ($dados['partidas'] != 0):
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>
                        <?php
                                else:
                        ?>
                        <tr class="empty">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                                endif;
                            }
                        endif
                        ?>
                    </table>
                </section>

                <section class="part">
                    <?php
                    $sql = "SELECT usuario, partidas FROM jogo_memoria ORDER BY partidas DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Partidas</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php   else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>

                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                    </table>
                </section>
            </section>
            <!-- FIM JOGO DA MEMORIA -->

            <?php 
                elseif ($jogo == "sudoku"):
            ?>

            <!-- SUDOKU -->
            <section class="jogos">
                <div>
                    <a href="lista.php?muda=true&jogo=memoria"><img src="./img/esquerda.png" alt=""></a>
                    <h1>Sudoku</h1>
                    <a href="lista.php?muda=true&jogo=2048"><img src="./img/direita.png" alt=""></a>
                </div>

                <section class="pont">
                    <?php
                    $sql = "SELECT usuario, pontuacao FROM sudoku ORDER BY pontuacao DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <thead>
                            <tr class="esp">
                                <td>Classificação</td>
                                <td>Nick</td>
                                <td>Pontuação</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($_SESSION['valido'])):
                                $email = $_SESSION['id_email'];
                                while ($dados = $con->fetch_array()){
                                    if ($email != $dados['usuario']):
                            ?>

                            <tr class="dados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"]
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>
                            <?php   else: ?>
                            <tr class="meusdados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"] 
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>

                            <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["pontuacao"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                        </tbody>    
                    </table>
                </section>

                <section class="tempo">
                    <?php
                    $sql = "SELECT usuario, concat(minutos, ' : ', segundos) as 'tempo', partidas FROM sudoku ORDER BY minutos, segundos";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Tempo</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($dados['partidas'] != 0):
                                    if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>
                        <?php       else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>

                        <?php
                                    endif;
                                else:
                        ?>
                        <tr class="empty">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                                if ($dados['partidas'] != 0):
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>
                        <?php
                                else:
                        ?>
                        <tr class="empty">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                                endif;
                            }
                        endif
                        ?>
                    </table>
                </section>

                <section class="part">
                    <?php
                    $sql = "SELECT usuario, partidas FROM sudoku ORDER BY partidas DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Partidas</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php   else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>

                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                    </table>
                </section>
            </section>
            <!-- FIM SUDOKU -->

            <?php 
                elseif ($jogo == "2048"):
            ?>

            <!-- 2048 -->
            <section class="jogos">
                <div>
                    <a href="lista.php?muda=true&jogo=sudoku"><img src="./img/esquerda.png" alt=""></a>
                    <h1>2048</h1>
                    <a href="lista.php?muda=true&jogo=velha"><img src="./img/direita.png" alt=""></a>
                </div>

                <section class="pont">
                    <?php
                    $sql = "SELECT usuario, pontuacao FROM mmxlviii ORDER BY pontuacao DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <thead>
                            <tr class="esp">
                                <td>Classificação</td>
                                <td>Nick</td>
                                <td>Pontuação</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($_SESSION['valido'])):
                                $email = $_SESSION['id_email'];
                                while ($dados = $con->fetch_array()){
                                    if ($email != $dados['usuario']):
                            ?>

                            <tr class="dados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"]
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>
                            <?php   else: ?>
                            <tr class="meusdados">
                                <td><?php echo $i."º lugar" ?></td>
                                <?php $i++ ?>
                                <td>
                                    <?php 
                                    $usuario = $dados["usuario"];
                                    $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                    $pesq = $mysqli->query($sql);
                                    $nick = $pesq->fetch_assoc();
                                    echo $nick["nick"] 
                                    ?>
                                </td>
                                <td><?php echo $dados["pontuacao"] ?></td>
                            </tr>

                            <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["pontuacao"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                        </tbody>    
                    </table>
                </section>

                <section class="tempo">
                    <?php
                    $sql = "SELECT usuario, concat(minutos, ' : ', segundos) as 'tempo', partidas FROM mmxlviii ORDER BY minutos, segundos";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Tempo</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($dados['partidas'] != 0):
                                    if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>
                        <?php       else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>

                        <?php
                                    endif;
                                else:
                        ?>
                        <tr class="empty">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                                if ($dados['partidas'] != 0):
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["tempo"] ?></td>
                        </tr>
                        <?php
                                else:
                        ?>
                        <tr class="empty">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                                endif;
                            }
                        endif
                        ?>
                    </table>
                </section>

                <section class="part">
                    <?php
                    $sql = "SELECT usuario, partidas FROM mmxlviii ORDER BY partidas DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Partidas</td>
                        </tr>

                        <?php
                        $i = 1;
                        if (isset($_SESSION['valido'])):
                            $email = $_SESSION['id_email'];
                            while ($dados = $con->fetch_array()){
                                if ($email != $dados['usuario']):
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php   else: ?>
                        <tr class="meusdados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"] 
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>

                        <?php
                                endif;
                            }
                        else:
                            while ($dados = $con->fetch_array()){
                        ?>
                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>
                        <?php
                            }
                        endif
                        ?>
                    </table>
                </section>
            </section>
            <!-- FIM 2048 -->
            <?php
                endif;
            else:
            ?>

            <!-- JOGO DA VELHA (SE USUÁRIO NÂO TIVER JOGADO NADA) -->
            <section class="jogos">
                <div>
                    <a href="lista.php?muda=true&jogo=2048"><img src="./img/esquerda.png" alt=""></a>
                    <h1>Jogo da velha</h1>
                    <a href="lista.php?muda=true&jogo=memoria"><img src="./img/direita.png" alt=""></a>
                </div>

                <section class="pont">
                    <?php
                    $sql = "SELECT usuario, pontuacao FROM jogo_velha ORDER BY pontuacao DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Pontuação</td>
                        </tr>

                        <?php
                        $i = 1;
                        while ($dados = $con->fetch_array()){
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["pontuacao"] ?></td>
                        </tr>

                        <?php
                        }
                        ?>
                    </table>
                </section>

                <section class="vit">
                    <?php
                    $sql = "SELECT usuario, vitorias FROM jogo_velha ORDER BY vitorias DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Vitórias</td>
                        </tr>

                        <?php
                        $i = 1;
                        while ($dados = $con->fetch_array()){
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["vitorias"] ?></td>
                        </tr>

                        <?php
                        }
                        ?>
                    </table>
                </section>

                <section class="part">
                    <?php
                    $sql = "SELECT usuario, partidas FROM jogo_velha ORDER BY partidas DESC";
                    $con = $mysqli->query($sql);
                    ?>
                    <table>
                        <tr class="esp">
                            <td>Classificação</td>
                            <td>Nick</td>
                            <td>Vitórias</td>
                        </tr>

                        <?php
                        $i = 1;
                        while ($dados = $con->fetch_array()){
                        ?>

                        <tr class="dados">
                            <td><?php echo $i."º lugar" ?></td>
                            <?php $i++ ?>
                            <td>
                                <?php 
                                $usuario = $dados["usuario"];
                                $sql = "SELECT nick FROM usuarios WHERE id_email = '$usuario'";
                                $pesq = $mysqli->query($sql);
                                $nick = $pesq->fetch_assoc();
                                echo $nick["nick"]
                                ?>
                            </td>
                            <td><?php echo $dados["partidas"] ?></td>
                        </tr>

                        <?php
                        }
                        ?>
                    </table>
                </section>
            </section>
            <!--  FIM JOGO DA VELHA (SE USUÁRIO NÂO TIVER JOGADO NADA) -->

            <?php
            endif
            ?>
        </div>
    </main>
</body>
</html>