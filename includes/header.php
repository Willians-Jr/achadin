<?php
include_once __DIR__ . '/config.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
  </head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark  menuPrincipal">
  
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand logoA" href="index.html">
    <img src="<?= BASE_URL ?>assets/IMG/Catavento.png" class="imgLogo" alt="LOGO">

    <div class="logoTexto">
        <span class="logo text-light">Top</span>
        <span class="logo text-light">Achados</span>
    </div>
</a>

        <!-- TELEFONE ICONE-->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarColor03"
            aria-controls="navbarColor03"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">

            <!-- BARRA DE BUSCA -->
    
<form class="d-flex mx-auto w-50 form formularioBusca" action="pesquisarProduto.php"role="search">

    <div class="position-relative flex-grow-1 me-2">
        <span class="material-symbols-outlined position-absolute top-50 end-0 translate-middle-y me-3 text-secondary">
            search
        </span>

        <input
            class="form-control pe-5"
            type="search"
            placeholder="Busca por palavra-chave..."
            aria-label="Busca">

            
    </div>

    <button class="btn btn-primary" type="submit">
        Buscar
    </button>

</form>

            <!-- MENU A DIREITA -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="menuPrincipalLinks">
                <li class="nav-item">
                    <a class="active nav-link link-light" href="#">Categorias</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link link-light" href="#">Produtos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link link-light" href="#">Lojas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link link-light" href="#">Como Funciona</a>
                </li>
            



                  <li class="favoritosIcon">
    <a href="#" class="btn active" role="button" data-bs-toggle="button" aria-pressed="true">
        <span class="material-symbols-outlined">
            favorite
        </span>

        <span>Meus Achadinhos</span>
    </a>
  </li>
            </ul>

        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
