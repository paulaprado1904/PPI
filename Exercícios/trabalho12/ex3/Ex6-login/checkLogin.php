<?php

class RequestResponse
{
  public $success;
  public $detail;

  function __construct($success, $detail)
  {
    $this->success = $success;
    $this->detail = $detail;
  }
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Validação simplificada para fins didáticos. Não faça isso!
if ($email == 'teste@mail.com' && $senha == '123456')
  $response = new RequestResponse(true, 'home.html');
else
  $response = new RequestResponse(false, '');

header('Content-type: application/json');
echo json_encode($response);

/*Ao inserir o email e senha incorretos, não haverá redirecionamento nem envio tradicional do formulário.
 Em vez disso, a página HTML receberá uma resposta JSON indicando que a autenticação falhou.

Passo a passo:

Quando os dados do formulário são enviados através do método POST, o JavaScript envia uma requisição AJAX para o
 arquivo PHP busca-endereco.php.
O PHP recebe esses dados e verifica se o email e a senha correspondem aos valores esperados. Neste exemplo, a verificação 
é feita de forma simplificada apenas para fins didáticos. Se o email for teste@mail.com e a senha for 123456, a resposta 
indicará sucesso ($response = new RequestResponse(true, 'home.html');). Caso contrário, a resposta indicará 
falha ($response = new RequestResponse(false, '');).
Em seguida, o PHP retorna essa resposta como um objeto JSON usando header('Content-type: application/json'); 
echo json_encode($response);.
De volta ao JavaScript, a resposta JSON é recebida pela função xhr.onload. Se a autenticação for bem-sucedida, o JavaScript 
pode realizar o redirecionamento de página. Se a autenticação falhar, o JavaScript pode exibir uma mensagem de erro ou tomar 
outra ação apropriada. */