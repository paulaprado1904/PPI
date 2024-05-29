<?php
class Endereco
{
  public $rua;
  public $bairro;
  public $cidade;

  // Método construtor para inicializar valores das propriedades
  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

// Obtém a string JSON da requisição
$stringJSON = file_get_contents('php://input');

// Converte a string JSON em objeto PHP
$dados = json_decode($stringJSON);
$cep = $dados->cep;

// Verifica o valor do CEP para determinar o endereço correspondente
if ($cep == '38400-100')
  $endereco = new Endereco('Av Floriano', 'Centro', 'Uberlândia');
else if ($cep == '38400-200')
  $endereco = new Endereco('Rua Tiradentes', 'Fundinho', 'Uberlândia');
else
  $endereco = new Endereco('', '', '');

// Define o cabeçalho da resposta como JSON
header('Content-type: application/json');

// Retorna o endereço como objeto JSON
echo json_encode($endereco);

/*Adicionou-se uma capacidade para receber dados através do método POST, em vez de apenas GET.
A requisição POST é usada para enviar dados em JSON, enquanto no exemplo anterior era uma requisição GET simples.
Os dados da requisição são lidos usando file_get_contents('php://input'), pois no POST os dados não estão diretamente acessíveis através do superglobal $_POST.
Os dados são decodificados do formato JSON para um objeto PHP usando json_decode.
A resposta é enviada como um objeto JSON usando json_encode. */
