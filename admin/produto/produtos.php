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

        <button class="btn btn-primary rounded-pill">
            Em Alta
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Eletrônicos
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Informática
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Smartphones
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Games
        </button>

    </div>

    <div class="row g-4">
        
    <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 shadow-sm">
        
        <a href="#" class="text-dark"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
        </svg></a>

                <div class="position-relative">
                   
                    <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>" 
                       target="_blank" 
                       onclick="window.location.href='?id=<?= $produto['idProduto'] ?>';" 
                       class="link-produto-vitrine">
                        <img src="<?= BASE_URL ?><?= !empty($produto['fotoProduto']) ? htmlspecialchars($produto['fotoProduto']) : 'sem-imagem.png' ?>"
                             class="card-img-top p-3 produto-img"
                             alt="<?= htmlspecialchars($produto['nomeProduto']) ?>">
                    </a>

                    <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">

                        <a href="#" class="text-dark">
                            <i class="bi bi-heart fs-4"></i>
                        </a>

                        <a href="#" class="text-dark">
                            <i class="bi bi-share fs-5"></i>
                        </a>

                    </div>

                </div>
                
                <div class="card-body">
                    
                    <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>" 
                       target="_blank" 
                       onclick="window.location.href='?id=<?= $produto['idProduto'] ?>';" 
                       class="link-produto-vitrine">
                        <h5 class="fw-bold">
                            <?= htmlspecialchars($produto['nomeProduto'], ENT_QUOTES, 'UTF-8') ?>
                        </h5>
                    </a>

                    <p class="text-secondary">
                        <?= htmlspecialchars($produto['descricaoProduto'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        
                        <h6 class="fw-bold">
                            R$ <?= htmlspecialchars($produto['precoProduto'], ENT_QUOTES, 'UTF-8') ?>
                        </h6>
                    

                </div>

            </div>
        </div>
    <?php } ?>

<div class="text-center mt-5">
 <button class="btn btn-primary">
    <span>Ver todos os produtos</span>
    <span class="seta">→</span>
</button>
</div>

</div>
</main>

<?php require_once ROOT_PATH . '/includes/footer.php';?>
</body>
</html>