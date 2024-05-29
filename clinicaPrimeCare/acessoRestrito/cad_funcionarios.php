<?php
ini_set('display_errors', 1); // Exibir erros para depuração

// Incluir o arquivo conexaoBanco.php
require_once '../php/conexaoMysql.php';

try {
    // Obter conexão com o banco de dados usando a função mysqlConnect() definida em conexaoBanco.php
    $conn = mysqlConnect();

    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $data_contrato = $_POST['inicio_contrato'];
    $salario = $_POST['salario'];
    $senha = $_POST['senha'];
    $tipo_funcionario = $_POST['tipo_funcionario'];
    $especialidade = isset($_POST['especialidade']) ? $_POST['especialidade'] : null;
    $crm = isset($_POST['crm']) ? $_POST['crm'] : null;

    $conn->beginTransaction();

    $stmt = $conn->prepare("INSERT INTO PESSOA (nome, sexo, email, telefone, cep, logradouro, cidade, estado) VALUES (:nome, :sexo, :email, :telefone, :cep, :logradouro, :cidade, :estado)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->execute();

    $codigo_pessoa = $conn->lastInsertId();

    $stmt = $conn->prepare("INSERT INTO FUNCIONARIO (data_contrato, salario, senha_hash, codigo) VALUES (:data_contrato, :salario, :senha_hash, :codigo)");
    $stmt->bindParam(':data_contrato', $data_contrato);
    $stmt->bindParam(':salario', $salario);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt->bindParam(':senha_hash', $senha_hash);
    $stmt->bindParam(':codigo', $codigo_pessoa);
    $stmt->execute();

    // Se o tipo de funcionário for médico, insire os dados na tabela de médico
    if ($tipo_funcionario === 'medico') {
        $stmt = $conn->prepare("INSERT INTO MEDICO (especialidade, crm, codigo) VALUES (:especialidade, :crm, :codigo)");
        $stmt->bindParam(':especialidade', $especialidade);
        $stmt->bindParam(':crm', $crm);
        $stmt->bindParam(':codigo', $codigo_pessoa);
        $stmt->execute();
    }

    $conn->commit();

    header("Location: cad_funcionarios.html?success=true");
    exit();
} catch(PDOException $e) {
    $conn->rollback();
    echo "Erro: " . $e->getMessage();
}
?>
