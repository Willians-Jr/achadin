<?php
require_once __DIR__ . '/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

$pesquisaCategoria = trim($_GET['pesquisaCategoria'] ?? '');

if ($pesquisaCategoria !== '') {
    $sql = "SELECT * FROM categoria WHERE nomeCategoria LIKE ? ORDER BY nomeCategoria ASC";
    $stmt = mysqli_prepare($conexao, $sql);
    $like = "%{$pesquisaCategoria}%";
    mysqli_stmt_bind_param($stmt, "s", $like);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    $sql = "SELECT * FROM categoria ORDER BY nomeCategoria ASC";
    $resultado = mysqli_query($conexao, $sql);
}

if (!$resultado) {
    die("Erro ao buscar categoria.");
}
?>

<!doctype html>
<html lang="pt-br">
  <?php $titulo = "Gerenciar Categoria"; 
    require_once ROOT_PATH . '/includes/head.php'; ?>
  <body>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>
    <h1>Categorias</h1>

    <form method="GET">
    <input
        type="search"
        name="pesquisaCategoria"
        placeholder="Pesquisar Categoria..."
        value="<?php echo htmlspecialchars($pesquisaCategoria, ENT_QUOTES, 'UTF-8'); ?>">
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
    <td><?php echo htmlspecialchars($dados['nomeCategoria'], ENT_QUOTES, 'UTF-8'); ?></td>

    <td>
        <a href="editarCategoria.php?idCategoria=<?php echo (int) $dados['idCategoria']; ?>">
            Alterar
        </a>
    </td>

    <td>
        <a href="excluirCategoria.php?idCategoria=<?php echo (int) $dados['idCategoria']; ?>"
           onclick="return confirm('Deseja realmente excluir esta categoria?')">
            Excluir
        </a>
    </td>
</tr>

<?php } ?>

</table>
  </body>
</html>
