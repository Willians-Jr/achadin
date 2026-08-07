<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

$sql = "SELECT * FROM loja ORDER BY nomeLoja";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro ao buscar lojas: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php
$titulo = "TopAchados - Lojas";
$cssPagina = 'assets/CSS/lojas.css';
require_once ROOT_PATH . '/includes/head.php';
?>

<body>

<?php require_once ROOT_PATH . '/includes/header.php'; ?>

<main class="py-5 bg-body-tertiary">

    <div class="container">

        <div class="text-center mb-5">
            <span class="badge bg-warning text-dark mb-2">
                Parceiros
            </span>

            <h2 class="fw-bold">
                Nossas Lojas Parceiras
            </h2>

            <p class="text-secondary">
                Clique na loja e conheça suas ofertas.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            <?php while($loja = mysqli_fetch_assoc($resultado)): ?>

                <div class="col-6 col-md-4 col-lg-3">

                    <a
                        href="<?= htmlspecialchars($loja['linkLoja']) ?>"
                        target="_blank"
                        class="card loja-card border-0 shadow-sm h-100 text-decoration-none">

                        <div class="card-body text-center bg-light">

                            <img
                                src="<?= BASE_URL ?>assets/UPLOAD/<?= htmlspecialchars($loja['logoLoja']) ?>"
                                alt="<?= htmlspecialchars($loja['nomeLoja']) ?>"
                                class="img-fluid mb-3 logo-loja">

                            

                        </div>

                    </a>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

</main>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>

</body>
</html>