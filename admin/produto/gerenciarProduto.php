<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
=</head>

<?php
include_once __DIR__ . '/../../includes/conexao.php';

$pesquisaProduto = isset($_GET['pesquisaProduto']) ? $_GET['pesquisaProduto'] : '';

if ($pesquisaProduto) {
    $sql = "SELECT * FROM produto WHERE nomeProduto LIKE '%$pesquisaProduto%' ORDER BY nomeProduto";
} else {
    $sql = "SELECT * FROM produto ORDER BY nomeProduto";
}

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro ao buscar o produto: " . mysqli_error($conexao));
}
?>

<body>

<h1>Produtos</h1>

<form method="GET">
    <input
        type="text"
        name="pesquisaProduto"
        placeholder="Pesquisar produto..."
        value="<?php echo htmlspecialchars($pesquisaProduto); ?>">
    <button type="submit">
        Pesquisar
    </button>
</form>

<table>
<?php
while ($dados = mysqli_fetch_assoc($resultado)) { ?>
  <tr>
    <td><?php
        $sqlProduto = "SELECT nomeProduto FROM produto WHERE idProduto = " . $dados['idProduto'];
        $resultProduto = mysqli_query($conexao, $sqlProduto);
        $dadosProduto = mysqli_fetch_assoc($resultProduto);
        echo $dadosProduto['nomeProduto'];
        ?></td>

    <td><?php
    $sqlLoja = "SELECT nomeLoja FROM loja WHERE idLoja = " . $dados['idLoja'];
    $resultLoja = mysqli_query($conexao, $sqlLoja);
    $dadosLoja = mysqli_fetch_assoc($resultLoja);
    echo $dadosLoja['nomeLoja'];
    ?> </td>   

    <td><?php
        $sqlCategoria = "SELECT nomeCategoria FROM categoria WHERE idCategoria = " . $dados['idCategoria'];
        $resultCategoria = mysqli_query($conexao, $sqlCategoria);
        $dadosCategoria = mysqli_fetch_assoc($resultCategoria);
        echo $dadosCategoria['nomeCategoria'];
        ?></td>
    <td><a href="editarProduto.php?id=<?php echo $dados['idProduto']; ?>">Alterar</a></td>
    <td>
      <a href="excluirProduto.php?id=<?php echo $dados['idProduto']; ?>"
         onclick="return confirm('Deseja realmente excluir este produto?')">
        Excluir
      </a>
    </td>
  </tr>
<?php } ?>
</table>
</body>
</html>