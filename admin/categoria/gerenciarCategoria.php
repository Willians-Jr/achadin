<?php
include_once __DIR__ . '/../../includes/conexao.php';

$pesquisaCategoria = isset($_GET['pesquisaCategoria']) ? $_GET['pesquisaCategoria'] : '';

if ($pesquisaCategoria) {
    $sql = "SELECT * FROM categoria WHERE nomeCategoria
 LIKE '%$pesquisaCategoria%'
    ORDER BY nomeCategoria ASC";
} else {
       $sql = "SELECT * FROM categoria ORDER BY nomeCategoria ASC";
}

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro ao buscar categoria" . mysqli_error($conexao));
}
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Categorias</title>
  </head>
  <body>
    <h1>Categorias</h1>

    <form method="GET">
    <input
        type="search"
        name="pesquisaCategoria"
        placeholder="Pesquisar Categoria..."
        value="<?php echo htmlspecialchars($pesquisaCategoria); ?>">
    <button type="submit">
        Pesquisar Categoria
    </button>
</form>

<table border="1">
<tr>
    <th>Nome</th>
    <th>Alterar</th>
    <th>Excluir</th>
</tr>

<?php while ($dados = mysqli_fetch_assoc($resultado)) { ?>

<tr>
    <td><?php echo $dados['nomeCategoria']; ?></td>

    <td>
        <a href="editarCategoria.php?idCategoria=<?php echo $dados['idCategoria']; ?>">
            Alterar
        </a>
    </td>

    <td>
        <a href="excluirCategoria.php?idCategoria=<?php echo $dados['idCategoria']; ?>"
        onclick="return confirm('Deseja realmente excluir esta categoria?')">
            Excluir
        </a>
    </td>
</tr>

<?php } ?>

</table>
  </body>
</html>
