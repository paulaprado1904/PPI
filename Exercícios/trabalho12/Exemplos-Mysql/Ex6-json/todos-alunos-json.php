<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$sql = <<<SQL
  SELECT *
  FROM aluno
SQL;

try {
  $stmt = $pdo->query($sql);
  $alunos = $stmt->fetchAll(PDO::FETCH_OBJ);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($alunos);
} 
catch (Exception $e) {
  exit('Falha inesperada: ' . $e->getMessage());
}
