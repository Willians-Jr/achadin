<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

// ======================================================
// REGISTRAR CLIQUE
// ======================================================

if (isset($_GET['id'])) {

    $idProdutoAtual = (int) $_GET['id'];
    $idUsuarioLogado = isset($_SESSION['idUsuario']) ? (int) $_SESSION['idUsuario'] : 1;

    $sqlInsert = "INSERT INTO historicoclique (idUsuario,idProduto)
                  VALUES (?,?)";

    $stmtInsert = mysqli_prepare($conexao, $sqlInsert);
    mysqli_stmt_bind_param($stmtInsert, "ii", $idUsuarioLogado, $idProdutoAtual);
    mysqli_stmt_execute($stmtInsert);
}

// ======================================================
// CATEGORIA SELECIONADA
// ======================================================

$idCategoria = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;

// ======================================================
// BUSCAR CATEGORIAS
// ======================================================

$sqlCategorias = "SELECT *
                  FROM categoria
                  ORDER BY nomeCategoria";

$resultadoCategorias = mysqli_query($conexao, $sqlCategorias);

// ======================================================
// BUSCAR PRODUTOS
// ======================================================



if ($idCategoria > 0) {

    $sql = "SELECT * FROM produto
            WHERE idCategoria = ?
            ORDER BY nomeProduto";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idCategoria);

} else {

    // MOSTRA TODOS OS PRODUTOS
    $sql = "SELECT * FROM produto
            ORDER BY nomeProduto";

    $stmt = mysqli_prepare($conexao, $sql);
}

mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!doctype html>
<html lang="pt-br">
<?php
$titulo = "TopAchados - Produtos";
require_once ROOT_PATH . '/includes/head.php';
?>

<body>

<?php require_once ROOT_PATH . '/includes/header.php'; ?>

<main>

<div class="container py-5">

    <h1 class="fw-bold display-5">
        Produtos
    </h1>

    <p class="text-secondary">
        Descubra ofertas e cupons para os produtos mais desejados.
    </p>

    <!-- CATEGORIAS -->

    <div class="d-flex flex-wrap gap-2 my-4">

        <a href="produtos.php"
            class="btn <?= $idCategoria == 0 ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">
                Todos
        </a>
    
        <?php while($categoria = mysqli_fetch_assoc($resultadoCategorias)) { ?>

            <a href="?categoria=<?= $categoria['idCategoria'] ?>"
               class="btn <?= $idCategoria == $categoria['idCategoria']
                    ? 'btn-primary'
                    : 'btn-outline-secondary' ?> rounded-pill">

                <?= htmlspecialchars($categoria['nomeCategoria']) ?>

            </a>

        <?php } ?>

    </div>

    <!-- PRODUTOS -->

    <div class="row g-4">

    <?php if(mysqli_num_rows($resultado) > 0){ ?>

        <?php while($produto = mysqli_fetch_assoc($resultado)){ ?>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                <div class="card h-100 shadow-sm border-0 position-relative">

                    <!-- Ícones -->

                    <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2" style="z-index:10;">

                        <a href="#"
                           class="text-dark bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                           style="width:36px;height:36px;">

                            <i class="bi bi-heart"></i>

                        </a>

                        <a href="#"
                           class="text-dark bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                           style="width:36px;height:36px;">

                            <i class="bi bi-share"></i>

                        </a>

                    </div>

                    <!-- IMAGEM -->

                    <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>"
                       target="_blank"
                       onclick="window.location.href='?categoria=<?= $idCategoria ?>&id=<?= $produto['idProduto'] ?>';"
                       class="text-center p-3">

                        <img
                            src="<?= BASE_URL . (!empty($produto['fotoProduto']) ? htmlspecialchars($produto['fotoProduto']) : 'assets/IMG/sem-imagem.png') ?>"
                            class="card-img-top img-fluid"
                            style="max-height:200px;object-fit:contain;"
                            alt="<?= htmlspecialchars($produto['nomeProduto']) ?>">

                    </a>

                    <!-- CORPO -->

                    <div class="card-body d-flex flex-column">

                        <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>"
                           target="_blank"
                           onclick="window.location.href='?categoria=<?= $idCategoria ?>&id=<?= $produto['idProduto'] ?>';"
                           class="text-decoration-none text-dark">

                            <h5 class="fw-bold fs-6">

                                <?= htmlspecialchars($produto['nomeProduto']) ?>

                            </h5>

                        </a>

                        <p class="text-secondary small flex-grow-1">

                            <?= htmlspecialchars($produto['descricaoProduto']) ?>

                        </p>

                        <h5 class="fw-bold text-primary">

                            R$ <?= number_format($produto['precoProduto'],2,',','.') ?>

                        </h5>

                    </div>

                </div>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="col-12">

            <div class="alert alert-warning text-center">

                Nenhum produto encontrado nesta categoria.

            </div>

        </div>

    <?php } ?>

    </div>

</div>

</main>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>

</body>
</html>