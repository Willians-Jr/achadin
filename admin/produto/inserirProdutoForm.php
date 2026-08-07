<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

    <?php $titulo = "TopAchados - Cadastro de Produto";
    $cssPagina = 'assets/CSS/admin.css';
    require_once ROOT_PATH . '/includes/head.php'; ?>
<body>
<?php require_once ROOT_PATH . '/includes/header.php'; ?>
<main>
<div class="container py-4">
 
    <div class="row shadow rounded-4 overflow-hidden ">
 
        <!-- Lado esquerdo -->
        <div class="ladoEsquerdoAdmin col-md-4 text-center p-5 border-end ">
 
            <!-- LOGO -->
            <a class="navbar-brand logoA" href="<?= BASE_URL ?>">
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
                Formulário de Cadastro de Produto
            </h1>
 
            <form action="inserirProduto.php" method="post" enctype="multipart/form-data">
 
                <div class="mb-3">
                    <label for="nomeProduto" class="form-label">
                        Nome do Produto:
                    </label>
 
                    <input
                        type="text"
                        class="form-control"
                        id="nomeProduto"
                        name="nomeProduto"
                        required
                        placeholder='Ex.: Monitor Gamer 27"'>
                </div>
 
                <div class="mb-3">
                    <label for="idCategoria" class="form-label">
                        Categoria:
                    </label>
 
                    <select
                        class="form-select"
                        id="idCategoria"
                        name="idCategoria"
                        required>
 
                        <?php
                            $sqlCategoria = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
                            $resultCategoria = mysqli_query($conexao, $sqlCategoria);
                            echo "<option value='' disabled selected>Selecione...</option>";
                            while ($dadosCategoria = mysqli_fetch_assoc($resultCategoria)) {
                                echo "<option value='" . $dadosCategoria['idCategoria'] . "'>" . $dadosCategoria['nomeCategoria'] . "</option>";
                            }
                        ?>
 
                    </select>
                </div>
 
                <div class="mb-3">
                    <label for="idLoja" class="form-label">
                        Loja:
                    </label>
 
                    <select
                        class="form-select"
                        id="idLoja"
                        name="idLoja"
                        required>
 
                        <?php
                            $sqlLoja = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
                            $resultLoja = mysqli_query($conexao, $sqlLoja);
                            echo "<option value='' disabled selected>Selecione...</option>";
                            while ($dadosLoja = mysqli_fetch_assoc($resultLoja)) {
                                echo "<option value='" . $dadosLoja['idLoja'] . "'>" . $dadosLoja['nomeLoja'] . "</option>";
                            }
                        ?>
 
                    </select>
                </div>
                <div class="mb-3">
                    <label for="precoProduto" class="form-label">
                        Preço:
                    </label>
 
                    <input
                        type="text"
                        class="form-control"
                        id="valor"
                        name="precoProduto"
                        required
                        placeholder='Ex.: 199.99'>
                </div>

                <div class="mb-3">
                    <label for="descricaoProduto" class="form-label">
                        Descrição:
                    </label>
 
                    <input
                        type="text"
                        class="form-control"
                        id="descricaoProduto"
                        name="descricaoProduto"
                        required
                        placeholder='Ex.: dispositivo periférico de entrada...'>
                </div>

                <div class="mb-3">
                    <label for="linkAfiliado" class="form-label">
                        Link de Afiliado:
                    </label>
 
                    <input
                        type="text"
                        class="form-control"
                        id="linkAfiliado"
                        name="linkAfiliado"
                        required
                        placeholder='Seu link de afiliado aqui...'>
                </div>
 
                <div class="mb-5">
                    <label for="fotoProduto" class="form-label">
                        Foto do Produto:
                    </label>
 
                    <input
                        type="file"
                        class="form-control"
                        id="fotoProduto"
                        name="fotoProduto"
                        accept=".jpg,.jpeg,.png,.gif,image/*"
                        data-recortar>
                </div>
 
                <div class="text-center">
 
                    <button
                        type="submit"
                        class="btn btn-primary rounded-pill px-5 py-2"
                        style="min-width:200px;">
 
                        Cadastrar Produto
 
                    </button>
 
                </div>
 
            </form>
 
        </div>
 
    </div>
 
</div>
</main>

<?php require_once ROOT_PATH . '/includes/footer.php';?>
<script src="<?= BASE_URL ?>assets/JS/mascara.js"></script>
</body>
</html>