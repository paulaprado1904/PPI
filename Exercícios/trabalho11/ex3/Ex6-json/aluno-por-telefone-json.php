<?php

require "../conexaoMysql.php"; // inclui o arquivo de conexão com o BD.
$pdo = mysqlConnect(); // inclui o arquivo de conexão com o banco de dados.

// recupera o parâmetro 'telefone' enviado via GET. Se não preencher, deixa a string vazia.
$telefone = $_GET['telefone'] ?? '';

// consulta SQL p selecionar todos os registros da tabela 'aluno' com o telefone especificado.
$sql = <<<SQL
  SELECT *
  FROM aluno
  WHERE telefone = ?
SQL;

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$telefone]); // execução da consulta com o telefone fornecido.
  $aluno = $stmt->fetch(PDO::FETCH_OBJ); // recuperação do 1º resultado da consulta como objeto.
  // Definição do cabeçalho HTTP para indicar que o conteúdo é um JSON com codificação UTF-8.
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($aluno); // converte o resultado para o formato JSON e exibição na saída.
} 
catch (Exception $e) {
  // tratamento de exceção em caso de erro durante a execução da consulta.
  exit('Falha inesperada: ' . $e->getMessage());
}
