<?php

// Definição da classe Endereco
class Endereco
{
  // Propriedades públicas para armazenar rua, bairro e cidade
  public $rua;
  public $bairro;
  public $cidade;

  // Método construtor para inicializar os valores das propriedades
  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

// Obtém o valor do parâmetro 'cep' da requisição GET ou define como uma string vazia caso não exista
$cep = $_GET['cep'] ?? '';

// Verifica o valor do CEP para determinar o endereço correspondente
if ($cep == '38400-100')
  $endereco = new Endereco('Av Floriano', 'Centro', 'Uberlândia');
else if ($cep == '38400-200')
  $endereco = new Endereco('Rua Tiradentes', 'Fundinho', 'Uberlândia');
else {
  $endereco = new Endereco('', '', ''); // Se o CEP não corresponder, retorna um endereço vazio
}

// Define o cabeçalho da resposta como JSON
header('Content-type: application/json');

// Retorna o endereço como um objeto JSON
echo json_encode($endereco);
