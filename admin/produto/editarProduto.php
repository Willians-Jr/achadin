<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

$dados = [
    'idProduto' => '',
    'nomeProduto' => '',
    'idCategoria' => '',
    'idLoja' => '',
    'linkAfiliado' => '',
    'descricaoProduto' => '',
    'fotoProduto' => ''
];

$idProduto = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($idProduto <= 0) {
    echo "<script>alert('ID do produto não informado!'); window.location='gerenciarProduto.php';</script>";
    exit;
}

$sqlProduto = "SELECT idProduto, nomeProduto, idCategoria, idLoja, fotoProduto, linkAfiliado, descricaoProduto, idUsuario FROM produto WHERE idProduto = ?";
$stmt = mysqli_prepare($conexao, $sqlProduto);
mysqli_stmt_bind_param($stmt, "i", $idProduto);
mysqli_stmt_execute($stmt);
$resultProduto = mysqli_stmt_get_result($stmt);

if ($resultProduto && mysqli_num_rows($resultProduto) > 0) {
    $dados = mysqli_fetch_assoc($resultProduto);
} else {
    mysqli_stmt_close($stmt);
    echo "<script>alert('Produto não encontrado!'); window.location='gerenciarProduto.php';</script>";
    exit;
}
mysqli_stmt_close($stmt);

exigirDonoOuAdmin((int) $dados['idUsuario']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php $titulo = "TopAchados - Editar Produto";
$cssPagina = 'assets/CSS/admin.css';
include_once ROOT_PATH . '/includes/head.php'; ?>

<body>
    <?php include_once ROOT_PATH . '/includes/header.php'; ?>
    <main>
        <div class="container py-4">

            <div class="row shadow rounded-4 overflow-hidden">

                <!-- Lado esquerdo -->
                <div class="ladoEsquerdoAdmin col-md-4 text-center p-5 border-end">

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
                        Formulário de Edição de Produto
                    </h1>

                    <form action="atualizarProduto.php" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="idProduto" value="<?php echo $dados['idProduto']; ?>">

                        <input type="hidden" name="fotoAtual" value="<?php echo $dados['fotoProduto']; ?>">

                        <div class="mb-3">
                            <label for="nomeProduto" class="form-label">
                                Nome do Produto:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="nomeProduto"
                                name="nomeProduto"
                                value="<?php echo htmlspecialchars($dados['nomeProduto']); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="idCategoria" class="form-label">
                                Categoria:
                            </label>
                            <select class="form-select" name="idCategoria" id="idCategoria" required>
                                <?php
                                $sqlCategoria = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
                                $resultCategoria = mysqli_query($conexao, $sqlCategoria);
                                while ($dadosCategoria = mysqli_fetch_assoc($resultCategoria)) {
                                    $selected = ($dadosCategoria['idCategoria'] == $dados['idCategoria']) ? 'selected' : '';
                                    echo "<option value='" . $dadosCategoria['idCategoria'] . "' $selected>" . $dadosCategoria['nomeCategoria'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="idLoja" class="form-label">
                                Loja:
                            </label>
                            <select class="form-select" name="idLoja" id="idLoja" required>
                                <?php
                                $sqlLoja = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
                                $resultLoja = mysqli_query($conexao, $sqlLoja);
                                while ($dadosLoja = mysqli_fetch_assoc($resultLoja)) {
                                    $selected = ($dadosLoja['idLoja'] == $dados['idLoja']) ? 'selected' : '';
                                    echo "<option value='" . $dadosLoja['idLoja'] . "' $selected>" . $dadosLoja['nomeLoja'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="linkAfiliado" class="form-label">
                                Link do Produto:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="linkAfiliado"
                                name="linkAfiliado"
                                value="<?php echo htmlspecialchars($dados['linkAfiliado']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="descricaoProduto" class="form-label">
                                Descrição do Produto:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="descricaoProduto"
                                name="descricaoProduto"
                                value="<?php echo htmlspecialchars($dados['descricaoProduto']); ?>">
                        </div>

                        <?php if (!empty($dados['fotoProduto'])): ?>
                            <div class="mb-3">
                                <label for="fotoProduto" class="form-label">
                                    Foto atual:
                                </label>
                                <div class="foto-preview">
                                    <img
                                        src="../<?php echo $dados['fotoProduto']; ?>"
                                        alt="Foto atual"
                                        class="foto-preview-img">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="fotoProduto" class="form-label">
                                Nova foto (opcional):
                            </label>
                            <input
                                type="file"
                                class="form-control"
                                id="fotoProduto"
                                name="fotoProduto"
                                accept="image/*"
                                data-recortar>
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
