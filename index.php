<?php
session_start();
include_once __DIR__ . '/includes/conexao.php';

?>
<br>
<a href="admin/produto/inserirProduto.php">Cadastrar Produto</a>
<a href="admin/usuario/inserirUsuarioForm.php">Cadastrar Usuario</a>
<a href="admin/loja/inserirLoja.php">Cadastrar loja</a>
<a href="admin/categoria/inserirCategoria.php">Cadastrar Categoria</a>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>
<body>
    <main>
   <?php include __DIR__ . '/includes/header.php'?> 
<!-- HEADER -->
<header class="bannerIndex text-center text-light py-5">
    <div class="container">

        <h1 class="display-1 opacity-50">
            BANNER
        </h1>
    </div>
</header>
<!-- FIM HEADER -->

<!-- LOJAS EM DESTAQUE -->
<div class="container mt-5">

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h6>Lojas em destaque</h6>

                <a href="#">Ver todas</a>

            </div>


            <div class="row g-3">

                <div class="col">
                    <div class="card p-3 text-center">
                        Shopee
                    </div>
                </div>

                <div class="col">
                    <div class="card p-3 text-center">
                        Mercado Livre
                    </div>
                </div>

                <div class="col">
                    <div class="card p-3 text-center">
                        Amazon
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- FIM LOJAS EM DESTAQUE -->
<!-- FILTROS -->
 
<div class="container my-4">

    <div class="d-flex flex-wrap gap-3">

        <button class="btn btn-light border">
            Todos os filtros
        </button>

        <select class="form-select w-auto">
            <option>Preços</option>
        </select>

        <select class="form-select w-auto">
            <option>Modelos</option>
        </select>

        <select name="categoriaProduto" id="categoriaProduto" class="form-select w-auto">
            <option>Categorias</option>
        </select>

    </div>

</div>

<!-- FIM FILTROS -->
<!-- PROTUTOS -->
<div class="container">

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">

        <div class="col">

            <div class="card h-100">

                <img src="#" class="card-img-top">

                <div class="card-body">

                    <h6 class="card-title">
                        Computador Completo
                    </h6>

                    <h4 class="text-danger">
                        R$ 731,45
                    </h4>

                    <small class="text-muted">
                        Via Amazon
                    </small>

                </div>

            </div>

        </div>

        <!-- outros cards -->

    </div>

</div>

<!-- FIM PRODUTOS -->
</main>

<?php include __DIR__ . '/includes/footer.php'?>

</body>
</html>
