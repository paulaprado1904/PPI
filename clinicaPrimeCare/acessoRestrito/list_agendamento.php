<?php
// Inicie a sessão para acessar as variáveis de sessão
session_start();

// Incluir o arquivo de conexão com o banco de dados
require_once '../php/conexaoMysql.php';

// Conexão com o banco de dados
$pdo = mysqlConnect();

// Consulta SQL para obter os agendamentos do médico logado
$sql = <<<SQL
    SELECT AGENDA.nome, AGENDA.data, AGENDA.horario, AGENDA.email, PESSOA.nome AS nome_medico, MEDICO.especialidade
    FROM AGENDA
    INNER JOIN MEDICO ON AGENDA.codigo_medico = MEDICO.codigo
    INNER JOIN FUNCIONARIO ON MEDICO.codigo = FUNCIONARIO.codigo
    INNER JOIN PESSOA ON FUNCIONARIO.codigo = PESSOA.codigo
    WHERE AGENDA.data >= CURRENT_DATE();
SQL;

try {
    $stmt = $pdo->query($sql);
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json; charset=utf-8');
    
    // Retorna os agendamentos como JSON
    echo json_encode($agendamentos);
} catch (Exception $e) {
    // Trate os erros de consulta aqui
    $response = array(
        'error' => true,
        'message' => 'Erro ao buscar agendamentos: ' . $e->getMessage()
    );
    echo json_encode($response);
}
header('Access-Control-Allow-Origin: *');
// Fechar conexão com o banco de dados
$pdo = null;
?>