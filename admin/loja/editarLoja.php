<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();
exigirAdmin();

// 1. Pega o ID da URL. Se não existir, define como null
$idLoja = $_GET['id'] ?? null;

// Inicializa a variável para evitar erros na exibição do HTML depois
$dadosLoja = null;

// 2. Só executa o banco se um ID válido foi enviado
if ($idLoja) {
    $sql = "SELECT * FROM loja WHERE idLoja = ?";

    if ($stmt = mysqli_prepare($conexao, $sql)) {
        
        // Vincula o parâmetro. O "i" significa que o ID deve ser tratado estritamente como Inteiro (Integer)
        mysqli_stmt_bind_param($stmt, "i", $idLoja);
        
        // Executa a consulta com segurança
        mysqli_stmt_execute($stmt);
        
        // Pega o resultado
        $resultado = mysqli_stmt_get_result($stmt);
        
        // Guarda os dados da loja
        $dadosLoja = mysqli_fetch_assoc($resultado);
    }
}

// 3. Se a loja não for encontrada ou o ID não for enviado, você pode tratar aqui
if (!$dadosLoja) {
    echo "Loja não encontrada.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php $titulo = "TopAchados - Editar Loja";
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
                        Formulário de Edição de Loja
                    </h1>

                    <form action="atualizarLoja.php" method="POST" enctype="multipart/form-data">

                        <input
                            type="hidden"
                            id="idLoja"
                            name="idLoja"
                            value="<?php echo $dadosLoja['idLoja']; ?>">

                        <div class="mb-3">
                            <label for="nomeLoja" class="form-label">
                                Nome da Loja:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="nomeLoja"
                                name="nomeLoja"
                                value="<?php echo htmlspecialchars($dadosLoja['nomeLoja']); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="linkLoja" class="form-label">
                                Link da Loja:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="linkLoja"
                                name="linkLoja"
                                value="<?php echo htmlspecialchars($dadosLoja['linkLoja']); ?>"
                                placeholder="Ex.: www.shopee.com">
                        </div>

                        <div class="mb-3">
                            <label for="logoLoja" class="form-label">
                                Logo atual:
                            </label>
                            <div class="logo-preview">
                                <img
                                    src="<?= BASE_URL ?>assets/UPLOAD/<?php echo htmlspecialchars($dadosLoja['logoLoja']); ?>"
                                    alt="Logo da Loja"
                                    class="logo-preview-img">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="logoLoja" class="form-label">
                                Nova logo (opcional):
                            </label>
                            <input
                                type="file"
                                class="form-control"
                                id="logoLoja"
                                name="logoLoja"
                                accept="image/*"
                                data-recortar>
                        </div>

                        <input
                            type="hidden"
                            name="logoAtual"
                            value="<?php echo htmlspecialchars($dadosLoja['logoLoja']); ?>">

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
