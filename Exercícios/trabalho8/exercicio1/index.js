// Seleciona todos os elementos <h2> e armazena no array subTitulos
const subTitulos = document.querySelectorAll("h2");

// Para cada elemento <h2> encontrado...
for (let subTitulo of subTitulos) {
    // Adiciona um ouvinte de evento de clique a cada <h2>
    subTitulo.addEventListener('click', function() {
        // Inicializa a variável elementoAtual com o próximo elemento irmão do <h2>
        let elementoAtual = subTitulo.nextElementSibling;

        // Enquanto houver um próximo elemento irmão e esse elemento não estiver oculto,
        // ele aplica a propriedade de display none. Fazendo assim para que contemple todos os elementos dentro de h2,
        //pois em alguns usados há mais de um elemento dentro do seu conteiner
        while (elementoAtual.style.display != 'none') {
            // Oculta o elemento atual definindo seu estilo de exibição como 'none'
            elementoAtual.style.display = 'none';
            // Passa para o próximo elemento irmão
            elementoAtual = elementoAtual.nextElementSibling;
        }
    });

    // Neste caso, usa a mesma lógica acima, porém ao inverso, para contemplar a regra ao duplo clique
    subTitulo.addEventListener('dblclick', function() {
        let elementoAtual = subTitulo.nextElementSibling;

        while (elementoAtual.style.display != 'block') {
            elementoAtual.style.display = 'block';
            elementoAtual = elementoAtual.nextElementSibling;
        }
    });
}
