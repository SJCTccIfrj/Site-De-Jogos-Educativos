<?php
    session_start();
    include("conexao.php");

    $sql = "SELECT id_email, nick, pontuacao FROM usuarios ORDER BY pontuacao DESC";
    $con = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="principal.css">
    <title>JDC</title>
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
                <li class="perfil2"><a class="inicio" href="lista.php">Ranking</a></li>
                <?php
                    endif
                ?>
            </ul>

            <img class="logo" src="./img/JDC.png" alt=""> 
        </div>
    </header>
    
    <main>
        <section class="jogos">
            <div class="conteiner">
                <a class="reset" href="jogadorvscomputador.php">
                    <img class="imagem" src="./img/jogoV.webp" alt="">
                    <p class="desc"><b>Jogo da velha</b><br>Seja o primeiro a fazer uma sequência de 3 símbolos iguais</p>
                </a>
            </div>
            <div class="conteiner">
                <a class="reset" href="jogadorvsjogador.php">
                    <img class="imagem" src="./img/jogoV.webp" alt="">
                    <p class="desc"><b>Jogo da velha</b><br> vs jogador <br> Esse modo não altera a pontuação <span style="color: white;">aaa</span></p>
                </a>
            </div>
            <div class="conteiner">
                <a class="reset" href="memoria.php">
                    <img class="imagem" src="./img/jogoM.png" alt="">
                    <p class="desc"><b>Jogo da memória</b><br>Ache todos os pares no menor número de tentativas</p>
                </a>
            </div>
            <div class="conteiner">
                <a class="reset" href="sudoku.php">
                    <img class="imagem" src="./img/sudoku.png" alt="">
                    <p class="desc"><b>Sudoku</b><br>Complete todos os quadrados o mais rápido possível <span style="color: white;">aaa</span></p>
                </a>
            </div>
            <div class="conteiner">
                <a class="reset" href="2048.php">
                    <img class="imagem" src="./img/2048.webp" alt="">
                    <p class="desc"><b>2048</b><br>Combine os números até chegar no 2048 <span style="color: white;">aaa</span></p>
                </a>
            </div>
        </section>
        
        <section class="anothercontainer">
            <div class="pont">
                <a href="lista.php">
                    <img src="./img/trofeu.png" alt="">
                    <h1>Ranking</h1>
                </a>
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
                        if ($i == 6) {
                            break;
                        }
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
                        if ($i == 6) {
                            break;
                        }
                        } 
                    endif 
                    ?>
                </table>
            </div>

            <div class="jog">
                <img src="./img/pacman.png" alt="">
                <h1>Continue jogando</h1>
                <?php
                    if(isset($_SESSION['valido'])):
                        $sql="SELECT ultimo_jogo FROM usuarios WHERE id_email = '$id_email'";
                        $pesq = $mysqli->query($sql);
                        $jogo = $pesq->fetch_assoc();
                        if ($jogo['ultimo_jogo'] == 'velha'):
                ?>
                <div>
                    <?php
                    $sql = "SELECT pontuacao, vitorias, derrotas, partidas FROM jogo_velha WHERE usuario = '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $data = $pesq->fetch_assoc(); 
                    ?>
                    <a href="jogadorvscomputador.php"><img class="cj" src="./img/jogoV2.png" alt=""></a>
                    <div>
                        <div><b>Partidas:</b> <?php echo $data['partidas'] ?></div>
                        <div><b>Vitórias:</b> <?php echo $data['vitorias'] ?></div>
                        <div><b>Derrotas:</b> <?php echo $data['derrotas'] ?></div>
                        <div><b>Pontuação:</b> <?php echo $data['pontuacao'] ?></div>
                    </div>
                </div>
                <?php
                        elseif ($jogo['ultimo_jogo'] == 'velha2'):
                ?>
                <div class="empty">
                    <a href="jogadorvsjogador.php"><img class="cj" src="./img/jogoV2.png" alt=""></a>
                    <p>Jogador vs Jogador</p>
                </div>
                <?php
                        elseif ($jogo['ultimo_jogo'] == 'memoria'):
                ?>
                <div class="memory">
                    <?php
                    $sql = "SELECT pontuacao, minutos, segundos, partidas FROM jogo_memoria WHERE usuario = '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $data = $pesq->fetch_assoc();
                    if ($data['partidas'] == 0){$data['minutos'] = 0;}
                    ?>
                    <a href="memoria.php"><img class="cjm" src="./img/jogoM2.png" alt=""></a>
                    <div>
                        <div><b>Partidas:</b> <?php echo $data['partidas'] ?></div>
                        <div><b>Pontuação:</b> <?php echo $data['pontuacao'] ?></div>
                        <div><b>Menor tempo:</b></div>
                        <div><?php echo $data['minutos']." : ".$data['segundos'] ?></div>
                    </div>
                </div>
                <?php
                        elseif ($jogo['ultimo_jogo'] == 'sudoku'):
                ?>
                <div class="memory">
                    <?php
                    $sql = "SELECT pontuacao, minutos, segundos, partidas FROM sudoku WHERE usuario = '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $data = $pesq->fetch_assoc();
                    if ($data['partidas'] == 0){$data['minutos'] = 0;}
                    ?>
                    <a href="sudoku.php"><img class="cjm" src="./img/sudoku2.png" alt=""></a>
                    <div>
                        <div><b>Partidas:</b> <?php echo $data['partidas'] ?></div>
                        <div><b>Pontuação:</b> <?php echo $data['pontuacao'] ?></div>
                        <div><b>Menor tempo:</b></div>
                        <div><?php echo $data['minutos']." : ".$data['segundos'] ?></div>
                    </div>
                </div>
                <?php
                        elseif ($jogo['ultimo_jogo'] == '2048'):
                ?>
                <div class="memory">
                    <?php
                    $sql = "SELECT pontuacao, minutos, segundos, partidas FROM mmxlviii WHERE usuario = '$id_email'";
                    $pesq = $mysqli->query($sql);
                    $data = $pesq->fetch_assoc();
                    if ($data['partidas'] == 0){$data['minutos'] = 0;}
                    ?>
                    <a href="2048.php"><img class="cjm" src="./img/2048(2).png" alt=""></a>
                    <div>
                        <div><b>Partidas:</b> <?php echo $data['partidas'] ?></div>
                        <div><b>Pontuação:</b> <?php echo $data['pontuacao'] ?></div>
                        <div><b>Menor tempo:</b></div>
                        <div><?php echo $data['minutos']." : ".$data['segundos'] ?></div>
                    </div>
                </div>
                <?php
                        else:
                ?>
                <div class="empty">
                    <img class="cj" src="./img/22.png" alt="">
                    <p>Você ainda não jogou nada!</p>
                    <p>Comece a jogar agora</p>
                </div>
                <?php
                        endif;
                    elseif (empty($_SESSION['valido'])):
                ?>
                <div class="empty">
                    <a href="login.php"><img class="cj" src="./img/22.png" alt=""></a>
                    <p>Você ainda não está logado!</p>
                    <p>Faça login para voltar a jogar</p>
                </div>
                <?php
                    endif
                ?>
            </div>
        </section>
    </main>
</body>
</html>