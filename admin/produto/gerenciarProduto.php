<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

exigirLogin();
exigirAdmin();

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
    die("Erro ao buscar produtos.");
}
?>

<!doctype html>
<html lang="pt-br">

<?php
$titulo = "Gerenciar Produtos";
$cssPagina = 'assets/CSS/admin.css';
require_once ROOT_PATH . '/includes/head.php';
?>

<body>

<?php require_once ROOT_PATH . '/includes/header.php'; ?>

<main class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <a href="<?= BASE_URL ?>" class="btn bg-dark-subtle">
            Menu Principal
        </a>

        <h1 class="fw-bold mb-0">
            Produtos
        </h1>

        <a href="inserirProdutoForm.php" class="btn bg-dark-subtle">
            Inserir Produto
        </a>

    </div>

    <div class="card shadow-lg border-0">

        <div class="card-body">

            <div class="col-lg-6 col-md-8 mb-4">

                <form method="GET">

                    <div class="d-flex gap-2">

                        <input
                            type="search"
                            class="form-control"
                            name="pesquisaProduto"
                            placeholder="Pesquisar produto..."
                            value="<?= htmlspecialchars($pesquisaProduto) ?>">

                        <button class="btn bg-info-subtle">
                            Pesquisar
                        </button>

                    </div>

                </form>

            </div>

            <div class="table-responsive">

                <table class="table table-striped table-hover align-middle text-center">

                    <thead class="table-primary">

                        <tr>

                            <th>Foto</th>
                            <th>Produto</th>
                            <th>Loja</th>
                            <th>Categoria</th>
                            <th colspan="2">Ações</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while($dados = mysqli_fetch_assoc($resultado)){ ?>

                        <tr>

                            <td>

                                <div class="foto-preview">

                                    <?php if (!empty($dados['fotoProduto']) && file_exists(ROOT_PATH . '/' . $dados['fotoProduto'])): ?>

                                        <img
                                            src="<?= BASE_URL . $dados['fotoProduto'] ?>"
                                            class="foto-preview-img"
                                            alt="<?= htmlspecialchars($dados['nomeProduto']) ?>">

                                    <?php else : ?>

                                        <span class="text-secondary small">
                                            Sem foto
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </td>

                            <td>
                                <?= htmlspecialchars($dados['nomeProduto']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($dados['nomeLoja']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($dados['nomeCategoria']) ?>
                            </td>

                            <td width="120">

                                <a
                                    href="editarProduto.php?id=<?= $dados['idProduto'] ?>"
                                    class="btn bg-warning-subtle btn-sm">

                                    Alterar

                                </a>

                            </td>

                            <td width="120">

                                <a
                                    href="excluirProduto.php?id=<?= $dados['idProduto'] ?>"
                                    class="btn bg-danger-subtle btn-sm"
                                    onclick="return confirm('Deseja realmente excluir este produto?')">

                                    Excluir

                                </a>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>

</body>

</html>