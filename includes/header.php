<?php
include_once __DIR__ . '/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

if (isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
$sqlnav = "SELECT imgUsuario,nivel FROM usuario WHERE idUsuario = ?";
$stmt = mysqli_prepare($conexao, $sqlnav);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$resultadu = mysqli_stmt_get_result($stmt);
$dado = mysqli_fetch_assoc($resultadu);
$imgUsuario = $dado['imgUsuario'];
$_SESSION['nivel'] = $dado['nivel'];
}


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
                    <a class="nav-link link-light" href="<?= BASE_URL ?>admin/loja/lojas.php">Lojas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link link-light" href="<?= BASE_URL ?>comoFunciona.php">Como Funciona</a>
                </li>

                <li class="favoritosIcon">
                    <?php if (!isset($_SESSION['idUsuario'])) { ?>
                    <a href="<?= BASE_URL ?>admin/usuario/loginUsuario.php" class="btn btn-outline-light" role="button" aria-pressed="true">
                        <span class="material-symbols-outlined">
                    login
                    </span><span>Login</span>
                        </a>
                    <?php } else{?>
                        <div class="dropdown">

    <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-2"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">

       <?php if (!empty($imgUsuario)){ ?>
    <img src="<?php echo BASE_URL . 'assets/UPLOAD/' . htmlspecialchars($imgUsuario); ?>"alt="Foto do usuário"class="rounded-circle"width="32"
                height="32" style="object-fit:cover;"><span>Perfil</span>
<?php }else{ ?>
    <i class="bi bi-person-circle"></i>
    


            
        <span>Perfil</span>
 <?php }}?> 
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow">

        <li class="dropdown-header">
            Bem-vindo, <?= htmlspecialchars($_SESSION['nomeUsuario']) ?>!
            <?php if ($_SESSION['nivel'] == 1) { ?>
                <span class="badge bg-danger ms-2">ADM</span>
            <?php } ?>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
            <a class="dropdown-item"
               href="<?= BASE_URL ?>admin/usuario/perfilUsuario.php">

                <span class="material-symbols-outlined me-2">
                    person
                </span>

                Gerenciar Perfil
            </a>
        </li>

        <li>
            <a class="dropdown-item"
               href="<?= BASE_URL ?>admin/usuario/logadoUsuario.php">

                <span class="material-symbols-outlined me-2">
                    dashboard
                </span>

                <?php if ($_SESSION['nivel'] == 1) { ?>
                    <span>Painel do Administrador</span>
                <?php } else { ?>
                    <span>Painel do Usuário</span>
                <?php } ?>
            </a>
        </li>
<?php if ($_SESSION['nivel']==1){ ?>
        <li>
            <a class="dropdown-item"
               href="<?= BASE_URL ?>admin/loja/inserirLojaForm.php">

                <span class="material-symbols-outlined me-2">
                    add_box
                </span>

                Adicionar Loja
            </a>
        </li>
        <li>
            <a class="dropdown-item"
               href="<?= BASE_URL ?>admin/categoria/inserirCategoriaForm.php">

                <span class="material-symbols-outlined me-2">
                    add_box
                </span>

                Adicionar Categoria
            </a>
        </li>
        <?php } ?>
        <li>
            <a class="dropdown-item"
               href="<?= BASE_URL ?>admin/produto/inserirProdutoForm.php">

                <span class="material-symbols-outlined me-2">
                    add_box
                </span>

                Adicionar Produto
            </a>
        </li>

        <li>
            <a class="dropdown-item disabled"
               href="<?= BASE_URL ?>favoritos.php">

                <span class="material-symbols-outlined me-2">
                    favorite
                </span>

                Favoritos
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
            <a class="dropdown-item text-danger"
               href="<?= BASE_URL ?>admin/usuario/logoutUsuario.php"
               onclick="return confirm('Tem certeza que deseja sair da sua conta?');">

                <span class="material-symbols-outlined me-2">
                    logout
                </span>

                Sair
            </a>
        </li>

    </ul>

</div>
                </li>
                    <li class ="nav-item">
                        <button id="btnTema" class="btn btn-outline-light">
                        <span id="iconeTema" class="material-symbols-outlined">
                            dark_mode
                        </span>
                        </button>
                    </li>
            </ul>
        </div>
    </div>
</nav>
<script>
const BASE_URL = "<?= BASE_URL ?>";
</script>

<script src="<?= BASE_URL ?>assets/JS/atualizarTema.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>