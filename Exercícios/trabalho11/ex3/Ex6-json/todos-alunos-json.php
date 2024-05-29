<?php

require "../conexaoMysql.php"; // Inclui do arquivo de conexão com o BD.
$pdo = mysqlConnect(); // estabelece aa conexão com o BD.

// consulta SQL p selecionar todos os registros da tabela 'aluno'.
$sql = <<<SQL
  SELECT *
  FROM aluno
SQL;

try {
  $stmt = $pdo->query($sql);
  $alunos = $stmt->fetchAll(PDO::FETCH_OBJ); // recupera todos os resultados da consulta como objetos.
  // define do cabeçalho HTTP para indicar que o conteúdo é um JSON com codificação UTF-8.
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($alunos); // converte os resultados para o formato JSON e exibição na saída.
}  
catch (Exception $e) {
  // tratamento de exceção em caso de erro durante a execução da consulta.
  exit('Falha inesperada: ' . $e->getMessage());
}
