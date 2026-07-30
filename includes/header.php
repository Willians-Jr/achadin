<?php
include_once __DIR__ . '/config.php';

?>
<nav class="navbar navbar-expand-lg navbar-dark  menuPrincipal">
 
    <div class="container-fluid">
 
        <!-- LOGO -->
        <a class="navbar-brand logoA" href="<?= BASE_URL ?>">
            <img src="<?= BASE_URL ?>assets/IMG/Catavento.png" class="imgLogo" alt="Logo Top Achados">
        
            <div class="logoTexto">
                <span class="logo">Top</span>
                <span class="logo">Achados</span>
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
    
<form class="d-flex mx-auto w-50 formularioBusca" method="GET" action="<?= BASE_URL ?>pesquisarProduto.php" role="search">

    <div class="position-relative flex-grow-1 me-2">
        <span class="material-symbols-outlined position-absolute top-50 end-0 translate-middle-y me-3 text-secondary">
            
        </span>
 
        <input
            class="form-control pe-5"
            type="search"
            name="pesquisa"
            value="<?= htmlspecialchars($_GET['pesquisa'] ?? '') ?>"
            placeholder="Busca por palavra-chave..."
            aria-label="Busca">
 
           
    </div>
 
    <button class="btn btn-primary" type="submit">
        Buscar
    </button>
 
</form>
 
            <!-- MENU A DIREITA -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="menuPrincipalLinks">
                <?php if (isset($_SESSION['idUsuario'])) { ?>

                <li class="nav-item">
                    <a class="nav-link link-light" href="<?= BASE_URL ?>admin/categoria/categorias.php">Categorias</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link link-light" href="<?= BASE_URL ?>admin/produto/produtos.php">Produtos</a>
                </li>
 
                <li class="nav-item">
                    <a class="nav-link link-light" href="<?= BASE_URL ?>admin/loja/gerenciarLoja.php">Lojas</a>
                </li>
 
                <li class="nav-item">
                    <a class="nav-link link-light" href="<?= BASE_URL ?>comoFunciona.php">Como Funciona</a>
                </li>
           
 
 
 
                <li class="favoritosIcon">
                         <?php if (!isset($_SESSION['idUsuario'])) { ?>
                         <a href="<?= BASE_URL ?>admin/usuario/loginUsuario.php" class="btn btn-outline-light" role="button" aria-pressed="true">
                        <span class="material-symbols-outlined">
                    login
                    </span>
        <?php } ?>
                    <span>Login</span>
                        </a>
                </li>
                    <li class ="nav-item">
                        <button id="btnTema" class="btn btn-outline-light">
                        <span id="iconeTema" class="material-symbols-outlined text-white">
                            dark_mode
                        </span>
                        </button>
                    </li>
            </ul>
 
        </div>
    </div>
</nav>

<script src="<?= BASE_URL ?>assets/JS/atualizarTema.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
 
 