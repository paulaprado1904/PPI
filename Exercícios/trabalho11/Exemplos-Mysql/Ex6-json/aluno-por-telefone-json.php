<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$telefone = $_GET['telefone'] ?? '';

$sql = <<<SQL
  SELECT *
  FROM aluno
  WHERE telefone = ?
SQL;

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$telefone]);
  $aluno = $stmt->fetch(PDO::FETCH_OBJ);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($aluno);
} 
catch (Exception $e) {
  exit('Falha inesperada: ' . $e->getMessage());
}
