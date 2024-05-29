<?php
// Inicie a sessão para acessar as variáveis de sessão
session_start();

// Incluir o arquivo de conexão com o banco de dados
require_once '../php/conexaoMysql.php';

// Conexão com o banco de dados
$pdo = mysqlConnect();

// Consulta SQL para obter os agendamentos do médico logado
$sql = <<<SQL
    SELECT CEP, Logradouro, Cidade, Estado
    FROM BASE_ENDERECOS;
SQL;


try {
    $stmt = $pdo->query($sql);
    $enderecos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json; charset=utf-8');
    
    // Retorna os agendamentos como JSON
    echo json_encode($enderecos);
} catch (Exception $e) {
    // Trate os erros de consulta aqui
    $response = array(
        'error' => true,
        'message' => 'Erro ao buscar enderecos: ' . $e->getMessage()
    );
    echo json_encode($response);
}
header('Access-Control-Allow-Origin: *');
// Fechar conexão com o banco de dados
$pdo = null;
?>