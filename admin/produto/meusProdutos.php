<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: " . BASE_URL . "login.php");
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT
            p.idProduto,
            p.nomeProduto,
            p.fotoProduto,
            p.linkAfiliado,
            c.nomeCategoria,
            l.nomeLoja
        FROM produto p
        INNER JOIN categoria c ON c.idCategoria = p.idCategoria
        INNER JOIN loja l ON l.idLoja = p.idLoja
        WHERE p.idUsuario = ?
        ORDER BY p.idProduto DESC";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<?php $titulo = "Meus Produtos - Painel"; require_once ROOT_PATH . '/includes/head.php'; ?>
<body>
  
<?php
require_once ROOT_PATH . '/includes/header.php';
?>


<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Meus Produtos</h2>

        <a href="produtos.php" class="btn btn-primary">
            <span class="material-symbols-outlined align-middle">
                add
            </span>
            Novo Produto
        </a>
    </div>
    <div class="row g-4">

<?php if(mysqli_num_rows($resultado) > 0): ?>

<?php while($produto = mysqli_fetch_assoc($resultado)): ?>

<div class="col-md-6 col-lg-4">

<div class="card h-100 shadow-sm">

<img
src="<?= BASE_URL . $produto['fotoProduto'] ?>"
class="card-img-top"
style="height:250px; object-fit:cover;"
>

<div class="card-body">

<h5 class="card-title">
<?= htmlspecialchars($produto['nomeProduto']) ?>
</h5>

<p class="text-muted mb-1">
Categoria:
<strong><?= htmlspecialchars($produto['nomeCategoria']) ?></strong>
</p>

<p class="text-muted">
Loja:
<strong><?= htmlspecialchars($produto['nomeLoja']) ?></strong>
</p>

<a
href="<?= htmlspecialchars($produto['linkAfiliado']) ?>"
target="_blank"
class="btn btn-outline-primary btn-sm w-100 mb-2">

Ver Produto

</a>

<div class="d-flex gap-2">

<a
href="editarProduto.php?id=<?= $produto['idProduto'] ?>"
class="btn btn-warning flex-fill">

Editar

</a>

<a
href="excluirProduto.php?id=<?= $produto['idProduto'] ?>"
class="btn btn-danger flex-fill"
onclick="return confirm('Deseja excluir este produto?')">

Excluir

</a>

</div>

</div>

</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="col-12">

<div class="alert alert-info text-center">

Você ainda não cadastrou nenhum produto.

</div>

</div>

<?php endif; ?>

</div>

</div>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>
</body>
</html>