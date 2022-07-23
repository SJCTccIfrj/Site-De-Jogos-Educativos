const cartas = document.getElementById("baralho");
const imagens = [
    './img/felpsanao.jpg', 
    './img/cellbitanao.jpg', 
    './img/lubaanao.jpg', 
    './img/calangoanao.webp', 
    './img/guaxinimanao.jpg', 
    './img/rakinanao.jpg', 
    './img/felpsanao.jpg', 
    './img/cellbitanao.jpg', 
    './img/lubaanao.jpg', 
    './img/calangoanao.webp', 
    './img/guaxinimanao.jpg', 
    './img/rakinanao.jpg'
];
let cartahtml = "";
let block = false;

function baralho() {
    document.getElementById("mensagem").innerHTML = ""

    let baralho = embaralhaCartas(imagens);
    for (let i = 0; i < imagens.length; i++) {
        cartahtml += "<div class='carta virada'><img src='"+ baralho[i] +"' class='frente'><img src='./img/lixo.jpg' class='verso'></div>"
    }
    cartas.innerHTML = cartahtml;
    setTimeout('comecaJogo()', 2000);
}

function comecaJogo() {
    for (let i = 0; i < imagens.length; i++) {
        let cart = document.querySelector(".carta.virada");
        cart.classList.remove('virada');
    }
}
 
function embaralhaCartas(imagens) {
    let j = 0
    for (let i = imagens.length-1; i>0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        [imagens[i], imagens[j]] = [imagens[j], imagens[i]];
    }
    return imagens
}

let primeiracarta, segundacarta;
let tentativas = 0, erros = 0, pontuacao = 0;

function vira() {
    if (!block) {
        this.classList.add('virada');
        let carta = this;
        carta = carta.childNodes[0];
        
        if (primeiracarta != undefined) {
            if (carta != primeiracarta) {
                block = true;
                segundacarta =  this;
                segundacarta = segundacarta.childNodes[0];
                setTimeout('checaCarta(primeiracarta, segundacarta)', 500);
            }
        } else {
            primeiracarta =  this;
            primeiracarta = primeiracarta.childNodes[0];
        }
    }
}

function checaCarta(primeira, segunda){
    tentativas += 1;
    block = false;

    if (primeira.src != segunda.src) {
        erros += 1;
        pontuacao -= 10;
        primeira.parentNode.classList.remove('virada');
        segunda.parentNode.classList.remove('virada');
        [primeiracarta, segundacarta] = [undefined, undefined];
    } else {
        pontuacao += 25;
        [primeiracarta, segundacarta] = [undefined, undefined];
        checaVitoria()
    }
}

function checaVitoria() {
    let viradas = document.querySelectorAll('.carta.virada');

    if (viradas.length == imagens.length) {
        clearInterval(tempo);

        let info = "Parabêns, Você conseguiu! <br> Tentativas: " + tentativas + "<br> Erros: " + erros + "<br> Pontuação: " + pontuacao + "<br>" + min + " : " + seg;
        document.getElementById("mensagem").innerHTML = info
        setTimeout('window.location = "validarmemoria.php?pontuacao="+pontuacao+"&min="+min+"&seg="+seg', 5000);
    }
}

let seg = 0, min = 0;

function cronometro() {
    if (seg < 60) {
        console.log(min+' : '+seg);
        seg++
    } else {
        min++
        seg = 0;
    }
}

baralho()
let tempo = setInterval(cronometro,1000);

const a = document.querySelectorAll('.carta');
a.forEach(a => a.addEventListener("click", vira));