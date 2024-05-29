<?php

// Inclui o arquivo de conexão com o banco de dados
require "../conexaoMysql.php";

// Estabelece a conexão com o banco de dados
$pdo = mysqlConnect();

try {
  // Consulta SQL para selecionar nome e telefone de todos os alunos
  $sql = <<<SQL
    SELECT nome, telefone
    FROM aluno
  SQL;

  // Executa a consulta SQL e armazena o resultado em $stmt
  $stmt = $pdo->query($sql);
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
  <!-- Meta tag para tornar a página responsiva -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hello World - Listagem de Dados em Tabela do MySQL</title>

  <!-- Inclui o CSS do Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <h3>Dados na tabela <b>aluno</b></h3>
    <table class="table table-striped table-hover">
      <tr>
        <th>Nome</th>
        <th>Telefone</th>
      </tr>
      <?php
      // Itera sobre cada linha do resultado da consulta
      while ($row = $stmt->fetch()) 
      {
        // Obtém o nome e o telefone de cada aluno e aplica htmlspecialchars para evitar XSS
        $nome = htmlspecialchars($row['nome']);
        $telefone = htmlspecialchars($row['telefone']);

        // Exibe os dados do aluno em uma linha da tabela HTML
        echo <<<HTML
        <tr>
          <td>$nome</td> 
          <td>$telefone</td>
        </tr>      
        HTML;
      }
      ?>
    </table>
    <!-- Link para retornar ao menu de opções -->
    <a href="../index.html">Menu de opções</a>
  </div>

</body>

</html>
