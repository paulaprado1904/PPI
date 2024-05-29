// Seleciona todos os elementos <img> no documento HTML e os armazena em uma NodeList -> img
const img = document.querySelectorAll("img");

// Itera sobre cada elemento <img> na NodeList img
for (let i of img) {
    // Quando o cursor do mouse entra no elemento <img>, adiciona a classe "destaca" para destacar a imagem
    i.onmouseenter = () => i.classList.add("destaca");
    
    // Quando o cursor do mouse deixa o elemento <img>, remove a classe "destaca" para remover o destaque da imagem
    i.onmouseleave = () => i.classList.remove("destaca");
}
