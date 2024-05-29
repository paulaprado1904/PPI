<?php

class Endereco
{
  public $rua;
  public $bairro;
  public $cidade;

  // Método construtor da classe Endereco que recebe os parâmetros rua, bairro e cidade e atribui esses valores aos atributos correspondentes.
  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

// Obtém o valor do parâmetro 'cep' da query string da URL. Se não houver, atribui uma string vazia.
$cep = $_GET['cep'] ?? '';

// Verifica se o valor do CEP é igual a '38400-100'.
if ($cep == '38400-100')
  // Se for, cria uma instância da classe Endereco com valores específicos para rua, bairro e cidade.
  $endereco = new Endereco('Av Floriano', 'Centro', 'Uberlândia');
// Caso contrário, verifica se o valor do CEP é igual a '38400-200'.
else if ($cep == '38400-200')
  // Se for, cria uma instância da classe Endereco com valores específicos para rua, bairro e cidade.
  $endereco = new Endereco('Rua Tiradentes', 'Fundinho', 'Uberlândia');
else
  // Se não corresponder a nenhum dos CEPs especificados, cria uma instância da classe Endereco com valores vazios para rua, bairro e cidade.
  $endereco = new Endereco('', '', '');

// Define o cabeçalho da resposta HTTP como JSON.
header('Content-Type: application/json; charset=utf-8');
// Converte o objeto $endereco para JSON e o imprime na saída.
echo json_encode($endereco);
