<?php
include_once __DIR__ . '/../../includes/conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $nomeCategoria = $_POST['nomeCategoria'];
  

  $sqlInsert = "INSERT INTO categoria (nomeCategoria) VALUES
  ('$nomeCategoria' )";

  if (mysqli_query($conexao, $sqlInsert)) {
        echo "<script>
                alert('Categoria cadastrada com sucesso!');
                window.location='inserirLoja.php';
              </script>";
    } else {
        echo "Erro ao cadastrar Loja: " . mysqli_error($conexao) . "<br><br>";
    }
}

$sql = "SELECT idCategoria, nomeCategoria FROM categoria";

$resultado = mysqli_query($conexao, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    echo "<h2>Categorias cadastradas</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID Categoria</th>
                <th>Nome Categoria</th>
            </tr>";

    while ($dados = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $dados['idCategoria'] . "</td>";
        echo "<td>" . $dados['nomeCategoria'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Nenhuma Categoria cadastrada.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Categoria</title>
</head>
<body>
    <h1>Registro de Categoria</h1>
    <br>

    <form action="inserirCategoria.php" method="post">
        <label for="nomeCategoria">Nome da Categoria:</label>
        <input type="text" name="nomeCategoria" id="nomeCategoria">

         <button type="submit">Cadastrar Categoria</button>

     
    </form>
</body>
</html>