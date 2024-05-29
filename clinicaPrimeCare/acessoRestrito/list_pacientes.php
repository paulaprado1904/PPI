<?php
// Inicie a sessão para acessar as variáveis de sessão
session_start();

// Incluir o arquivo de conexão com o banco de dados
require_once '../php/conexaoMysql.php';

// Conexão com o banco de dados
$pdo = mysqlConnect();

// Consulta SQL para obter os agendamentos do médico logado
$sql = <<<SQL
    SELECT 
        PESSOA.nome, 
        PESSOA.sexo, 
        PESSOA.email, 
        PACIENTE.peso, 
        PACIENTE.altura, 
        PACIENTE.tipo_sanguineo
    FROM PACIENTE
    INNER JOIN PESSOA ON PACIENTE.codigo = PESSOA.codigo;
SQL;



try {
    $stmt = $pdo->query($sql);
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json; charset=utf-8');
    
    // Retorna os agendamentos como JSON
    echo json_encode($pacientes);
} catch (Exception $e) {
    // Trate os erros de consulta aqui
    $response = array(
        'error' => true,
        'message' => 'Erro ao buscar funcionários: ' . $e->getMessage()
    );
    echo json_encode($response);
}
header('Access-Control-Allow-Origin: *');
// Fechar conexão com o banco de dados
$pdo = null;
?>