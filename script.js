const celulas = document.querySelectorAll(".celula")
console.log(celulas)
const jogador_X = "X"
const jogador_O = "O"
const combinacoes = [
    [0, 1, 2], [3, 4, 5], [6, 7, 8],  // horizontal
    [0, 3, 6], [1, 4, 7], [2, 5, 8],  // vertical
    [0, 4, 8], [2, 4, 6]              // diagonal
]
let fimdejogo = false



//   ----------------------------------------------------------------
// identificador do bloco selecionado

document.addEventListener("click", (event) => {
    if (event.target.matches(".celula")) {
        jogar(event.target.id, jogador_X)
    }

})

// ----------------------------------------------------------------
// BOT

function bot() {
    let jogada = -1
    let comb = []
    let cont = []
    for (i=0;i<9;i++){
        cont.push(document.getElementById(i).textContent)
        if (cont.length == 3){
            comb.push(cont)
            cont = []
        }
    }
    console.log(comb)
    let id0 = 0
    let id1 = 1
    let id2 = 2
    for (let l=0; l<3; l++){
        if (comb[l][0] == "X" && comb[l][2] == "X" && comb[l][1] == ""){jogada = id1}
        if (comb[l][0] == "X" && comb[l][1] == "X" && comb[l][2] == ""){jogada = id2}
        if (comb[l][2] == "X" && comb[l][1] == "X" && comb[l][0] == ""){jogada = id0}
        id0 += 3
        id1 += 3
        id2 += 3
    }
    id0 = 0
    id1 = 3
    id2 = 6
    for (let c=0; c<3; c++){
        if (comb[0][c] == "X" && comb[1][c] == "X" && comb[2][c] == ""){jogada = id2}
        if (comb[0][c] == "X" && comb[2][c] == "X" && comb[1][c] == ""){jogada = id1}
        if (comb[2][c] == "X" && comb[1][c] == "X" && comb[0][c] == ""){jogada = id0}
        id0 += 1
        id1 += 1
        id2 += 1
    }
    if (comb[0][0] == "X" && comb[1][1] == "X" && comb[2][2] == ""){jogada = 8}
    if (comb[0][0] == "X" && comb[1][1] == "" && comb[2][2] == "X"){jogada = 4}
    if (comb[0][0] == "" && comb[1][1] == "X" && comb[2][2] == "X"){jogada = 0}
    if (comb[2][0] == "X" && comb[1][1] == "X" && comb[0][2] == ""){jogada = 2}
    if (comb[0][2] == "X" && comb[1][1] == "X" && comb[2][0] == ""){jogada = 6}
    if (comb[0][2] == "X" && comb[1][1] == "" && comb[2][0] == "X"){jogada = 4}

    if (jogada == -1){
        let posicoesdisponiveis = []
        for (index in celulas) {
            if (!isNaN(index)) {
                if (!celulas[index].classList.contains("X") && !celulas[index].classList.contains("O")) {
                    posicoesdisponiveis.push(index)
                }
            }
            
        }
        let posicaoaleatoria = Math.floor(Math.random() * posicoesdisponiveis.length)
        jogada = posicoesdisponiveis[posicaoaleatoria]
    }
    
    if (!fimdejogo){
        jogar(jogada, jogador_O)
    }
}



// ----------------------------------------------------------------
// marcações dos jogadores

function jogar(id, turno) {
    const celula = document.getElementById(id)
    if (!celula.classList.contains("X") && !celula.classList.contains("O")) {
        celula.textContent = turno
        celula.classList.add(turno)
        ChecarVencedor(turno)
        if (turno == jogador_X){
        setTimeout(() => bot(), 400)
        }
    }
}

//   --------------------------------------------------------------
// verificar se houve algum ganhador

function ChecarVencedor(turno) {
    const vencedor = combinacoes.some((comb) => {
        return comb.every((index) => {
            return celulas[index].classList.contains(turno)
        })
    })

    if (vencedor) {
        encerrarJogo(turno)
    } else if (checarEmpate()) {
        encerrarJogo()
    }

}

//   ------------------------------
// verificar se houve um empate

function checarEmpate() {
    let x = 0
    let o = 0

    for (index in celulas) {
        if (!isNaN(index)) {

            if (celulas[index].classList.contains(jogador_X)) {
                x++
            }
            if (celulas[index].classList.contains(jogador_O)) {
                o++
            }
        }
    }
    return x + o === 9 ? true : false
}

//   --------------------------------------------------------------
// encerramento do game  /  RESTART  /

function encerrarJogo(vencedor = null) {
    fimdejogo = true
    const telapreta = document.getElementById("tela-preta")
    const h2 = document.createElement("h2")
    const h3 = document.createElement("h3")
    let msg = null
    var empate = 0
	
    telapreta.style.display = "block"
    telapreta.appendChild(h2)
    telapreta.appendChild(h3)

    if (vencedor) {
	if (vencedor == jogador_X) {
        h2.innerHTML = `VOCÊ VENCEU!`
	} else {
		h2.innerHTML = `O COMPUTADOR VENCEU!`
	}
    }else {
        h2.innerHTML = "Empatou"
	empate = 1
    }

    let contador = 3
    setInterval(() => {
        if (contador <= 0){
            contador = 0;
        }
        h3.innerHTML = `reiniciando em... ${contador--}`;
    }, 1000)
    if (vencedor == jogador_X) {
        setTimeout(() => window.location = "validarvitoria.php", 4500)
    }else if (vencedor == jogador_O){
        setTimeout(() => window.location = "validarderrota.php", 4500)
    }else {
	setTimeout(() => location.reload(), 4500)
    }
}