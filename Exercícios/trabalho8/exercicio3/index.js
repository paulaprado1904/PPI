// Executa a função quando a janela HTML e seus recursos foram carregados
window.onload = function (){
    // Obtém o campo de entrada de interesse pelo seletor de ID "interesse"
    const campoInteresse = document.querySelector("#interesse");

    // Adiciona um ouvinte de evento (e) ao campo de entrada de interesse que escuta por pressionamentos de tecla
    campoInteresse.addEventListener("keyup", e => {
        // Verifica se a tecla pressionada é a tecla Enter
        if (e.key === "Enter")
            // Se a tecla pressionada for Enter, chama a função adicionaInteresse()
            adicionaInteresse();
    });
}

// Outra opção para Adicionar a informação digitada. Pelo clique no botão:

// Obtém o botão de adicionar pelo seletor de tag "button"
const botaoAdicionar = document.querySelector("button");

// Adiciona um evento de clique ao botão de adicionar
botaoAdicionar.onclick = () => {
    // Quando o botão é clicado, chama a função adicionaInteresse()
    adicionaInteresse();
}

// Define a função adicionaInteresse() que será chamada quando um novo interesse for adicionado e acionado pela tecla ou clique no botão 'Adicionar'
function adicionaInteresse(){
    // Obtém o campo de entrada de interesse pelo seletor de ID "interesse"
    const campoInteresse = document.querySelector("#interesse");
    
    // Obtém a lista ordenada onde serão dispostos os interesses, pelo seletor de tag "ol"
    const listaInteresses = document.querySelector("ol");

    // Cria um novo elemento de lista (<li>) e um novo botão (<button>)
    const novoLi = document.createElement("li");
    const novoBotao = document.createElement("button");

    // Define o texto do novo elemento de lista como o valor do campo de entrada de interesse
    novoLi.textContent = campoInteresse.value;

    // Define o texto do novo botão como '✕' (um símbolo de fechar)
    novoBotao.textContent = '✕';

    // Adiciona o novo botão como um filho do novo elemento de lista
    novoLi.appendChild(novoBotao);

    // Adiciona o novo elemento de lista como um filho da lista de interesses <ol>
    listaInteresses.appendChild(novoLi);

    // Define um evento de clique para o novo botão que remove o respectivo elemento de lista quando clicado em 'X'
    novoBotao.onclick = function() {
        listaInteresses.removeChild(novoLi);
    }

    // Limpa o valor do campo de entrada de interesse
    campoInteresse.value = '';
}
