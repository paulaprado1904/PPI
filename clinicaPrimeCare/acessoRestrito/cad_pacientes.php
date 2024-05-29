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
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];

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

    $stmt = $conn->prepare("INSERT INTO PACIENTE (peso, altura, tipo_sanguineo, codigo) VALUES (:peso, :altura, :tipo_sanguineo, :codigo)");
    $stmt->bindParam(':peso', $peso);
    $stmt->bindParam(':altura', $altura);
    $stmt->bindParam(':tipo_sanguineo', $tipo_sanguineo);
    $stmt->bindParam(':codigo', $codigo_pessoa);
    $stmt->execute();

    $conn->commit();

    header("Location: cad_pacientes.html?success=true");
    exit();
} catch(PDOException $e) {
    $conn->rollback();
    echo "Erro: " . $e->getMessage();
}
?>
