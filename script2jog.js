const celulas = document.querySelectorAll(".celula")
const jogador_X = "X"
const jogador_O = "O"
const combinacoes = [
    [0, 1, 2], [3, 4, 5], [6, 7, 8],  // horizontal
    [0, 3, 6], [1, 4, 7], [2, 5, 8],  // vertical
    [0, 4, 8], [2, 4, 6]              // diagonal
]
let ChecarTurno = true

//   ----------------------------------------------------------------
// identificador do bloco selecionado

document.addEventListener("click", (event) => {
    if (event.target.matches(".celula")) {
        jogar(event.target.id)
    }

})

// ----------------------------------------------------------------
// marcações dos jogadores

function jogar(id) {
    const celula = document.getElementById(id)
    turno = ChecarTurno ? jogador_X : jogador_O
	if (!celula.classList.contains("X") && !celula.classList.contains("O")) {
    		celula.textContent = turno
    		celula.classList.add(turno)
    		ChecarVencedor(turno)
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
    } else {
        ChecarTurno = !ChecarTurno

    }

}

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

function encerrarJogo(vencedor = null) {
    const telapreta = document.getElementById("tela-preta")
    const h2 = document.createElement("h2")
    const h3 = document.createElement("h3")
    let msg = null

    telapreta.style.display = "block"
    telapreta.appendChild(h2)
    telapreta.appendChild(h3)

    if (vencedor) {
        h2.innerHTML = `O jogador <span>${vencedor}</span> VENCEU!`
    } else {
        h2.innerHTML = "Empatou"
    }

    let contador = 3
    setInterval (() => {
        h3.innerHTML = `reiniciando em... ${contador--}`;
    }, 1000)
    setTimeout (() => location.reload(), 4500)

}