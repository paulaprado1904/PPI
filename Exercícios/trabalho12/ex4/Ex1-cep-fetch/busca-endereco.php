<?php

class Endereco
{
  public $rua;
  public $bairro;
  public $cidade;

  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

// Obtém o CEP enviado via POST
$cep = $_POST['cep'] ?? '';

// Verifica o valor do CEP e cria um objeto Endereco correspondente
if ($cep == '38400-100')
  $endereco = new Endereco('Av Floriano', 'Centro', 'Uberlândia');
else if ($cep == '38400-200')
  $endereco = new Endereco('Rua Tiradentes', 'Fundinho', 'Uberlândia');
else
  $endereco = new Endereco('', '', '');

// Define o cabeçalho Content-Type para indicar que está sendo enviado JSON
header('Content-Type: application/json; charset=utf-8');
// Retorna os dados do endereço em formato JSON
echo json_encode($endereco);
?>
