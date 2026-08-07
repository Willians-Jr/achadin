<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();
exigirAdmin();

$idCategoria = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($idCategoria <= 0) {
    die("ID da categoria inválido.");
}

$sql = "SELECT * FROM categoria WHERE idCategoria = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idCategoria);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$resultado) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

$dadosCategoria = mysqli_fetch_assoc($resultado);

if (!$dadosCategoria) {
    die("Categoria não encontrada.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php $titulo = "TopAchados - Editar Categoria";
$cssPagina = 'assets/CSS/admin.css';
include_once ROOT_PATH . '/includes/head.php'; ?>

<body>
    <?php include_once ROOT_PATH . '/includes/header.php'; ?>
    <main>
        <div class="container py-4">

            <div class="row shadow rounded-4 overflow-hidden ">

                <!-- Lado esquerdo -->
                <div class="ladoEsquerdoAdmin col-md-4 text-center p-5 border-end ">

                    <!-- LOGO -->
                    <a class="navbar-brand logoA" href="<?= BASE_URL ?>index.php">
                        <img src="<?= BASE_URL ?>assets/IMG/Catavento.png" class="imgLogo" alt="LOGO">

                        <div class="logoTexto">
                            <span class="logo">Top</span>
                            <span class="logo">Achados</span>
                        </div>
                    </a>

                    <h5 class="fw-bold text-white">"O que você busca está aqui!"</h5>

                </div>

                <!-- Lado direito -->
                <div class="col-md-8 p-5">

                    <h1 class="text-center mb-5">
                        Formulário de Edição de Categoria
                    </h1>

                    <form action="atualizarCategoria.php" method="POST">

                        <input
                            type="hidden"
                            name="idCategoria"
                            value="<?php echo $dadosCategoria['idCategoria']; ?>">

                        <div class="mb-3">
                            <label for="nomeCategoria" class="form-label">
                                Nome da Categoria:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="nomeCategoria"
                                name="nomeCategoria"
                                required
                                value="<?php echo htmlspecialchars($dadosCategoria['nomeCategoria']); ?>">
                        </div>

                        <div class="text-center">

                            <button
                                type="submit"
                                class="btn btn-primary rounded-pill px-5 py-2"
                                style="min-width:200px;">

                                Salvar Alterações

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </main>
    <?php include_once ROOT_PATH . '/includes/footer.php'; ?>

</body>
</html>
