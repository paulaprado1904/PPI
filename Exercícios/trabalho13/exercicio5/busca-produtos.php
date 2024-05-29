<?php
// Conexão com o banco de dados (substitua os valores conforme necessário)
$db_host = "sql109.infinityfree.com";
  $db_username = "if0_35771770";
  $db_password = "sy8EB1IX013";
  $db_name = "if0_35771770_ppi";

// Cria a conexão
$conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_username, $db_password, $options);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se a marca foi enviada pela URL
if(isset($_GET['marca'])){
    $marca = $_GET['marca'];

    // Query para selecionar os produtos da marca indicada
    $sql = "SELECT nome, descricao FROM produtos WHERE marca = '$marca'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $produtos = array();

        // Itera sobre os resultados e armazena em um array
        while($row = $result->fetch_assoc()) {
            $produto = array(
                "nome" => $row["nome"],
                "descricao" => $row["descricao"]
            );
            array_push($produtos, $produto);
        }

        // Retorna os produtos no formato JSON
        echo json_encode($produtos);
    } else {
        echo "0 results";
    }
} else {
    echo "Marca não especificada";
}

$conn->close();
?>
