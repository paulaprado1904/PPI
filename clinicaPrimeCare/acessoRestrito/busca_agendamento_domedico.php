<?php
// Inicie a sessão para acessar as variáveis de sessão
session_start();

// Verifique se o médico está autenticado
if (!isset($_SESSION['codigo_medico'])) {
    // Se o médico não estiver autenticado, retorne uma resposta de erro
    $response = array(
        'error' => true,
        'message' => 'Médico não autenticado'
    );
    echo json_encode($response);
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
require_once '../../../php/conexaoMysql.php';

// Conexão com o banco de dados
$pdo = mysqlConnect();

// Recupere o código do médico da sessão
$codigo_medico = $_SESSION['codigo_medico'];

// Consulta SQL para obter os agendamentos do médico logado
$sql = "SELECT nome, data, horario, sexo, email FROM AGENDA WHERE codigo_medico = :codigo_medico";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codigo_medico', $codigo_medico, PDO::PARAM_INT);
    $stmt->execute();
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

// Fechar conexão com o banco de dados
$pdo = null;
?>
