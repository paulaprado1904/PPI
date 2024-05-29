// Define a função validaForm como um manipulador de evento para o evento 'submit' do formulário com o id 'cadastro'
document.forms.cadastro.onsubmit = validaForm;

// Define a função validaForm que será chamada quando o formulário com o id 'cadastro' for submetido
function validaForm(e) {
    // Obtém o formulário que está sendo submetido
    let form = e.target;
    
    // Inicializa uma variável para verificar se o formulário é válido
    let formValido = true;

    // Obtém as referências para os elementos de feedback (spans) para usuário, senha e email
    const spanUsuario = form.usuario.nextElementSibling;
    const spanSenha = form.senha.nextElementSibling;
    const spanEmail = form.email.nextElementSibling;

    // Cria os spans de feedback, inicialmente vazios
    spanUsuario.textContent = "";
    spanSenha.textContent = "";
    spanEmail.textContent = "";

    // Verifica se o campo de usuário está vazio e exibe uma mensagem se estiver
    if (form.usuario.value === "") {
        spanUsuario.textContent = 'Usuário deve ser preenchido';
        formValido = false;
    }
    
    // Verifica se o campo de senha está vazio e exibe uma mensagem se estiver
    if (form.senha.value === "") {
        spanSenha.textContent = 'A senha deve ser preenchida';
        formValido = false;
    }
    
    // Verifica se o campo de email está vazio e exibe uma mensagem se estiver
    if (form.email.value === "") {
        spanEmail.textContent = 'O email deve ser preenchido';
        formValido = false;
    }

    // Se o formulário não for válido, cancela o evento de submissão
    if (!formValido)
        e.preventDefault();
}
