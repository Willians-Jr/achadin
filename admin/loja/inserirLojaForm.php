<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Lojas - Cadastrar</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
   
</head>
<?php require_once ROOT_PATH . '/includes/header.php'; ?>
 
<body class="bg-light">
 
<div class="container py-4">
 
    <div class="row shadow rounded-4 overflow-hidden bg-white">
 
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
 
              <form action="inserirLoja.php" method="post">
 
                <div class="mb-3">
                   <label class="form-label" for="nomeLoja">Nome da Loja:</label>
        <input class="form-control" type="text" name="nomeLoja" id="nomeLoja" required placeholder="Ex.: Shopee">
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
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>

<?php require_once ROOT_PATH . '/includes/footer.php';?>