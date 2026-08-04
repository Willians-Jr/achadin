<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';


// =========================================================================

// =========================================================================
if (isset($_GET['id'])) {
    $idProdutoAtual = intval($_GET['id']); 
    $idUsuarioLogado = isset($_SESSION['idUsuario']) ? intval($_SESSION['idUsuario']) : 1;
    
    // Insere o clique atual no histórico
    $sqlInsert = "INSERT INTO historicoclique (idUsuario, idProduto) VALUES ($idUsuarioLogado, $idProdutoAtual)";
    mysqli_query($conexao, $sqlInsert);
}
// =========================================================================

// =========================================================================

$sql = "SELECT * FROM produto ORDER BY nomeProduto";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!doctype html>
<html lang="pt-br">
<head>
   <?php $titulo="TopAchados - Produtos";
require_once ROOT_PATH . '/includes/head.php'; ?>
</head>

<body>
 <?php require_once ROOT_PATH . '/includes/header.php'; ?>
<main>
<div class="container py-5">

    <h1 class="fw-bold display-5">Produtos</h1>

    <p class="text-secondary">
        Descubra ofertas e cupons para os produtos mais desejados.
    </p>

    <div class="d-flex gap-3 flex-wrap my-4">
        <button class="btn btn-primary rounded-pill">Em Alta</button>
        <button class="btn btn-outline-secondary rounded-pill">Eletrônicos</button>
        <button class="btn btn-outline-secondary rounded-pill">Informática</button>
        <button class="btn btn-outline-secondary rounded-pill">Smartphones</button>
        <button class="btn btn-outline-secondary rounded-pill">Games</button>
    </div>

    <div class="row g-4">
        <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    
                    <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2" style="z-index: 10;">
                        <a href="#" class="text-dark bg-white rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-heart fs-6"></i>
                        </a>
                        <a href="#" class="text-dark bg-white rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-share fs-6"></i>
                        </a>
                    </div>

                    <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>" 
                       target="_blank" 
                       onclick="window.location.href='?id=<?= $produto['idProduto'] ?>';" 
                       class="text-center p-3">
                        <img src="<?= BASE_URL ?><?= !empty($produto['fotoProduto']) ? htmlspecialchars($produto['fotoProduto']) : 'assets/IMG/sem-imagem.png' ?>"
                             class="card-img-top img-fluid"
                             style="max-height: 200px; object-fit: contain;"
                             alt="<?= htmlspecialchars($produto['nomeProduto']) ?>">
                    </a>
                    
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>" 
                               target="_blank" 
                               onclick="window.location.href='?id=<?= $produto['idProduto'] ?>';" 
                               class="text-decoration-none text-dark">
                                <h5 class="fw-bold fs-6 mb-2">
                                    <?= htmlspecialchars($produto['nomeProduto'], ENT_QUOTES, 'UTF-8') ?>
                                </h5>
                            </a>

                            <p class="text-secondary small mb-3">
                                <?= htmlspecialchars($produto['descricaoProduto'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>

                        <div>
                            <h5 class="fw-bold text-primary m-0">
                                R$ <?= number_format((float)$produto['precoProduto'], 2, ',', '.') ?>
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div> <div class="text-center mt-5">
        <button class="btn btn-primary rounded-pill px-4">
            <span>Ver todos os produtos</span>
            <span class="ms-1">→</span>
        </button>
    </div>

</div>
</main>

<?php require_once ROOT_PATH . '/includes/footer.php';?>
</body>
</html>