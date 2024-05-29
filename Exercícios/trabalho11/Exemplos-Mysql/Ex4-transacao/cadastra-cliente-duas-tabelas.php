<?php

// Requer o arquivo de conexão com o banco de dados
require "../conexaoMysql.php";

// Estabelece a conexão com o banco de dados
$pdo = mysqlConnect();

// Resgata os dados do cliente do array $_POST
$nome = $_POST["nome"] ?? "";
$cpf  = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";
$altura = $_POST["altura"] ?? "";
$estadocivil = $_POST["estadocivil"] ?? "";
$datanascimento = $_POST["datanascimento"] ?? "";

/* $_POST é uma superglobal em PHP que é utilizada para coletar dados submetidos através do método HTTP POST de um formulário HTML.
 Quando um formulário é submetido usando o método POST, os dados dos campos do formulário são enviados para o servidor e podem ser
  acessados no script PHP através da superglobal $_POST.

Por exemplo, se você tiver um formulário HTML com campos de entrada nomeados como "nome", "email", "senha", etc., e você submeter 
esse formulário, os valores desses campos estarão disponíveis na superglobal $_POST no script PHP que processa o formulário.

A superglobal $_POST é um array associativo, onde as chaves são os nomes dos campos do formulário e os valores são os dados 
submetidos por meio desses campos. */


// Resgata os dados do endereço do cliente do array $_POST
$cep = $_POST["cep"] ?? "";
$endereco = $_POST["endereco"] ?? "";
$bairro = $_POST["bairro"] ?? "";
$cidade = $_POST["cidade"] ?? "";

// Calcula um hash seguro da senha para armazenar no banco de dados
$hashsenha = password_hash($senha, PASSWORD_DEFAULT);

// Query SQL para inserir os dados do cliente na tabela 'cliente'
$sql1 = <<<SQL
  INSERT INTO cliente (nome, cpf, email, hash_senha, 
                       data_nascimento, estado_civil, altura)
  VALUES (?, ?, ?, ?, ?, ?, ?)
  SQL;

// Query SQL para inserir os dados do endereço na tabela 'endereco_cliente'
$sql2 = <<<SQL
  INSERT INTO endereco_cliente 
    (cep, endereco, bairro, cidade, id_cliente)
  VALUES (?, ?, ?, ?, ?)
  SQL;

try {
  // Inicia uma transação
  $pdo->beginTransaction();

  // Prepara a primeira declaração SQL para inserir dados do cliente
  $stmt1 = $pdo->prepare($sql1);
  // Executa a primeira declaração, passando os valores como parâmetros
  if (!$stmt1->execute([
    $nome, $cpf, $email, $hashsenha,
    $datanascimento, $estadocivil, $altura
  ])) throw new Exception('Falha na primeira inserção');

  // Obtém o ID do cliente recém-inserido na tabela 'cliente'
  $idNovoCliente = $pdo->lastInsertId();

  // Prepara a segunda declaração SQL para inserir dados do endereço, incluindo o ID do cliente
  $stmt2 = $pdo->prepare($sql2);
  // Executa a segunda declaração, passando os valores como parâmetros
  if (!$stmt2->execute([
    $cep, $endereco, $bairro, $cidade, $idNovoCliente
  ])) throw new Exception('Falha na segunda inserção');

  // Confirma as operações da transação
  $pdo->commit();

  // Redireciona para a página de menu de opções após o cadastro bem-sucedido
  header("location: ../index.html");
  exit();
} 
catch (Exception $e) {
  // Em caso de erro, reverte a transação
  $pdo->rollBack();
  // Verifica se houve violação de chave única (duplicação de dados)
  if ($stmt1->errorInfo()[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
?>
