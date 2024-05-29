<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$telefone = $_POST["telefone"] ?? "";



  // NÃO FAÇA ISSO! Exemplo de código vulnerável a inj. de S-Q-L

  /* O código abaixo se demonstra vulnerável pois a forma de inserção diretamente pelo insert buscando a variável 
  refereciada,  considera a string passada pelo usuário. Ao fazer a substituição da string no código SQL de inserção, 
  o conteúdo é substituido na query,e se o mesmo contiver comandos SQL, serão interpretados e executados.  
  */
  /*
  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES ('$nome', '$telefone');
  SQL;  
*/
  // Experimente fazer o cadastro de um novo aluno preenchendo 
  // o campo telefone utilizando o texto disponibilizado pelo professor
  // nos slides de aula
  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES ( ? , ?);
  SQL; 
  
  try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $telefone]);
  header("location: mostra-alunos.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
