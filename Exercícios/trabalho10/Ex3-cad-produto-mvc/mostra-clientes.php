<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <!-- 1: Tag de responsividade -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Produtos cadastrados</title>

  <!-- 2: Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <style>
    body {
      padding-top: 2rem;
    }

    img {
      width: 20px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h3>Produtos Cadastrados</h3>
    <table class="table table-striped table-hover">
      <tr>
        <th></th>
        <th>Nome</th>
        <th>Marca</th>
        <th>Descrição</th>
      </tr>

      <?php
      foreach ($arrayProdutos as $produto) {
        echo <<<HTML
          <tr>
            <td><a href="controlador.php?acao=excluirProduto&nome=$produto->nome">Excluir</a></td> 
            <td>$produto->nome</td> 
            <td>$produto->marca</td>
            <td>$produto->descricao</td>
          </tr>      
        HTML;
      }
      ?>

    </table>
    <p><a href="../index.html">Menu de opções</a></p>
  </div>

</body>

</html>