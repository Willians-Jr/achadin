<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

$pesquisaProduto = trim($_GET['pesquisaProduto'] ?? '');

if ($pesquisaProduto !== '') {
    $sql = "SELECT p.*, c.nomeCategoria, l.nomeLoja 
            FROM produto p
            INNER JOIN categoria c ON p.idCategoria = c.idCategoria
            INNER JOIN loja l ON p.idLoja = l.idLoja
            WHERE p.nomeProduto LIKE ? 
            ORDER BY p.nomeProduto";
    $stmt = mysqli_prepare($conexao, $sql);
    $like = "%{$pesquisaProduto}%";
    mysqli_stmt_bind_param($stmt, "s", $like);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    $sql = "SELECT p.*, c.nomeCategoria, l.nomeLoja 
            FROM produto p
            INNER JOIN categoria c ON p.idCategoria = c.idCategoria
            INNER JOIN loja l ON p.idLoja = l.idLoja
            ORDER BY p.nomeProduto";
    $resultado = mysqli_query($conexao, $sql);
}

if (!$resultado) {
    die("Erro ao buscar o produto.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<?php $titulo = "TopAchados - Gerenciar Produtos";
require_once ROOT_PATH . '/includes/head.php'; ?>
<body>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>

<h1>Produtos</h1>

<form method="GET">
    <input
        type="text"
        name="pesquisaProduto"
        placeholder="Pesquisar produto..."
        value="<?php echo htmlspecialchars($pesquisaProduto); ?>">
    <button type="submit">Pesquisar</button>
</form>

<br>
<table border=1>
    <body>
    <?php
    while ($dados = mysqli_fetch_assoc($resultado)) { 
    ?>
      <tr>
        <td>
            <?php if (!empty($dados['fotoProduto']) && file_exists("../../" . $dados['fotoProduto'])): ?>
                <img src="../../<?php echo $dados['fotoProduto']; ?>" alt="Foto do produto" width="50" height="50" style="object-fit: cover;">
            <?php else: ?>
                <span>Sem foto</span>
            <?php endif; ?>
        </td>

        <td><?php echo htmlspecialchars($dados['nomeProduto']); ?></td>
        <td><?php echo htmlspecialchars($dados['nomeLoja']); ?></td>
        <td><?php echo htmlspecialchars($dados['nomeCategoria']); ?></td>
        
        <td>
            <a href="editarProduto.php?id=<?php echo $dados['idProduto']; ?>">Alterar</a>
        </td>
        <td>
          <a href="excluirProduto.php?id=<?php echo $dados['idProduto']; ?>"
             onclick="return confirm('Deseja realmente excluir este produto?')">
            Excluir
          </a>
        </td>
      </tr>
    <?php 
    } 
    ?>
    </body>
</table>

</body>
</html>
