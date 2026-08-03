<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
 
<?php $titulo = "TopAchados - Cadastro de Categoria";
require_once ROOT_PATH . '/includes/head.php'; ?>


 
<body>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>
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
                Formulário de Cadastro de Categoria
            </h1>
 
              <form action="inserirCategoria.php" method="post">
 
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
                        placeholder="Ex.: Tecnologia">
                </div>
 
                <div class="text-center">
 
                    <button
                        type="submit"
                        class="btn btn-primary rounded-pill px-5 py-2"
                        style="min-width:200px;">
 
                        Cadastrar Categoria
 
                    </button>
 
                </div>
 
            </form>
 
        </div>
 
    </div>
 
</div>
</main>
 <?php require_once ROOT_PATH . '/includes/footer.php';?>

 
</body>
</html>

