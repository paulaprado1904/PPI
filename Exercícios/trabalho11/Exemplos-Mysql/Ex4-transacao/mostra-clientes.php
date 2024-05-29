<?php

// Requer o arquivo de conexão com o banco de dados
require "../conexaoMysql.php";

// Estabelece a conexão com o banco de dados
$pdo = mysqlConnect();

try {
  // Query SQL para selecionar nome, email, endereço, bairro e cidade de clientes
  $sql = <<<SQL
  SELECT nome, email, endereco, bairro, cidade
  FROM cliente INNER JOIN endereco_cliente ON cliente.id = id_cliente
  SQL;

  // Executa a consulta SQL
  // Nota: Não é utilizado prepared statements neste exemplo porque não há entrada de usuário na consulta SQL
  // Portanto, não há risco de injeção de SQL
  $stmt = $pdo->query($sql);
  /*A seta (->) em PHP é conhecida como operador de acesso a membros de objetos. Ela é utilizada para acessar métodos e 
  propriedades de objetos.

No contexto específico de $pdo->query($sql), $pdo é uma variável que contém um objeto PDO (ou seja, uma conexão com o banco de dados),
 e query($sql) é um método desse objeto PDO.

Portanto, $pdo->query($sql) está chamando o método query() do objeto PDO representado pela variável $pdo, e passando como 
argumento a consulta SQL contida na variável $sql. Esse método é usado para executar uma consulta SQL no banco de dados e retorna 
um objeto PDOStatement contendo os resultados da consulta, ou false em caso de falha.*/
} 
catch (Exception $e) {
  // Em caso de falha, exibe uma mensagem de erro e encerra o script
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <!-- Tag meta para tornar a página responsiva -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de clientes</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <style>
    body {
      padding-top: 2rem;
    }
  </style>
</head>

<body>

  <div class="container">
    <!-- Título da página -->
    <h3>Clientes e seus endereços</h3>
    <!-- Tabela para exibir os clientes e seus endereços -->
    <table class="table table-striped table-hover">
      <tr>
        <th>Cliente</th>
        <th>Email</th>
        <th>Endereço</th>
        <th>Bairro</th>
        <th>Cidade</th>
      </tr>

      <?php
      // Loop para percorrer os resultados da consulta
      /*O método fetch() em PHP é usado para recuperar a próxima linha de um conjunto de resultados retornado por uma 
      consulta ao banco de dados. Ele é frequentemente usado em conjunto com o método query() do objeto PDOStatement.*/
      while ($row = $stmt->fetch()) {

        // Limpa os dados produzidos pelo usuário para evitar XSS
        $nome = htmlspecialchars($row['nome']);
        $email = htmlspecialchars($row['email']);
        $endereco = htmlspecialchars($row['endereco']);
        $bairro = htmlspecialchars($row['bairro']);
        $cidade = htmlspecialchars($row['cidade']);

        // Exibe os dados na tabela HTML
        echo <<<HTML
          <tr>
            <td>$nome</td> 
            <td>$email</td>
            <td>$endereco</td>
            <td>$bairro</td>
            <td>$cidade</td>
          </tr>      
        HTML;
      }
      ?>

    </table>
    <!-- Link de volta para o menu de opções -->
    <a href="../index.html">Menu de opções</a>
  </div>

</body>

</html>
