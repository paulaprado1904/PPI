<?php

function checkLogin($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT hash_senha
    FROM cliente
    WHERE email = ?
    SQL;

  try {
    // Neste caso utilize prepared statements para prevenir
    // inj. de S Q L, pois precisamos inserir dados fornecidos
    // pelo usuário na consulta SQL (o email do usuário)
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if (!$row) return false; // nenhum resultado (email não encontrado)

/* A função password_verify em PHP é usada para verificar se uma senha fornecida corresponde ao hash de senha 
armazenado no banco de dados. Ela compara a senha fornecida com o hash usando um método seguro que protege as 
senhas dos usuários, pois não expõe informações sobre a senha real.

$senha: Este é o valor da senha que o usuário forneceu para autenticação.
$row['hash_senha']: Este é o hash de senha armazenado no banco de dados, geralmente recuperado durante o processo de autenticação.

A função password_verify realiza a verificação de uma maneira segura, sem revelar informações sobre a senha real. 
Ela compara o hash da senha fornecida com o hash armazenado, em vez de comparar as senhas em si.

*/


    return password_verify($senha, $row['hash_senha']);
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

if (checkLogin($pdo, $email, $senha))
  header("location: home.html");
else
  header("location: index.html");
