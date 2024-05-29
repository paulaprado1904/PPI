<?php
// Incluir o arquivo de conexão com o banco de dados
require_once './php/conexaoMysql.php';

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $nomePaciente = $_POST['nome'];
    $emailPaciente = $_POST['email'];
    $sexoPaciente = $_POST['sex']; 
    $dataConsulta = $_POST['data_consulta'];
    $horarioConsulta = $_POST['horario']; // O valor do horário será enviado via campo oculto
    $nomeMedico = $_POST['nome_medico'];

    try {
        // Conexão com o banco de dados
        $pdo = mysqlConnect();

        // Consultar o código do médico com base no nome fornecido
        $sqlCodigoMedico = "SELECT m.codigo FROM MEDICO m
                            INNER JOIN FUNCIONARIO f ON m.codigo = f.codigo
                            INNER JOIN PESSOA p ON f.codigo = p.codigo
                            WHERE p.nome = :nomeMedico";

        $stmtCodigoMedico = $pdo->prepare($sqlCodigoMedico);
        $stmtCodigoMedico->bindParam(':nomeMedico', $nomeMedico, PDO::PARAM_STR);
        $stmtCodigoMedico->execute();

        // Verificar se o médico foi encontrado
        if ($stmtCodigoMedico->rowCount() > 0) {
            $codigoMedico = $stmtCodigoMedico->fetch(PDO::FETCH_ASSOC)['codigo'];

            // Formatar a data no formato aceito pelo MySQL (YYYY-MM-DD)
            $dataConsultaFormatted = date('Y-m-d', strtotime($dataConsulta));

            // Preparar a consulta SQL para inserir os dados na tabela AGENDA
            $sql = "INSERT INTO AGENDA (data, horario, nome, sexo, email, codigo_medico) 
                    VALUES (:data, :horario, :nomePaciente, :sexoPaciente, :emailPaciente, :codigoMedico)";

            // Preparar e executar a consulta
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':data', $dataConsultaFormatted, PDO::PARAM_STR);
            $stmt->bindParam(':horario', $horarioConsulta, PDO::PARAM_STR);
            $stmt->bindParam(':nomePaciente', $nomePaciente, PDO::PARAM_STR);
            $stmt->bindParam(':sexoPaciente', $sexoPaciente, PDO::PARAM_STR);
            $stmt->bindParam(':emailPaciente', $emailPaciente, PDO::PARAM_STR);
            $stmt->bindParam(':codigoMedico', $codigoMedico, PDO::PARAM_INT);
            $stmt->execute();

            // Verificar se os dados foram inseridos com sucesso
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
            } else {
                echo "Erro ao cadastrar os dados.";
            }
        } else {
            echo "Médico não encontrado.";
        }
    } catch (Exception $e) {
        // Em caso de erro, retornar uma mensagem de erro
        echo "Erro ao cadastrar os dados: " . $e->getMessage();
    }
} else {
    // Se o formulário não foi submetido via POST, retornar uma mensagem de erro
    echo "Erro: o formulário não foi submetido corretamente.";
}
header("Location: agendamento.html?success=true");
?>
