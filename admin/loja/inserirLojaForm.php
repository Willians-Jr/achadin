<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php $titulo = "TopAchados - Cadastro de Loja";
require_once ROOT_PATH . '/includes/head.php'; ?>

 
<body>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>
<main>
<div class="container py-4">
 
    <div class="row shadow rounded-4 overflow-hidden">
 
        <!-- Lado esquerdo -->
        <div class="ladoEsquerdoAdmin col-md-4 text-center p-5 border-end ">
 
            <!-- LOGO -->
            <a class="navbar-brand logoA" href="index.html">
            <img src="../../assets/IMG/Catavento.png" class="imgLogo" alt="LOGO">
 
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
                Formulário de Cadastro de Loja
            </h1>
 
              <form action="inserirLoja.php" method="post" enctype="multipart/form-data">
 
                <div class="mb-3">
                   <label class="form-label" for="nomeLoja">Nome da Loja:</label>
        <input class="form-control" type="text" name="nomeLoja" id="nomeLoja" required placeholder="Ex.: Shopee">
                </div>

                <div class="mb-3">
                   <label class="form-label" for="nomeLoja">Link da Loja:</label>
        <input class="form-control" type="text" name="linkLoja" id="linkLoja" required placeholder="Ex.: www.shopee.com">
                </div>
 
                 <div class="mb-3">
                   <label class="form-label" for="logoLoja">Logo da Loja:</label>
        <input class="form-control" type="file" name="logoLoja" id="logoLoja" accept="image/*" required>
                </div>
 
                <div class="text-center">
 
                    <button
                        type="submit"
                        class="btn btn-primary rounded-pill px-5 py-2"
                        style="min-width:200px;">
 
                        Cadastrar Loja
 
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

