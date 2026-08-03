<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

$pesquisa="";

if (isset($_GET['nomeProduto'])){
  $pesquisa=trim($_GET['nomeProduto']);
  
}
$sqlProduto = "SELECT * FROM produto WHERE nomeProduto LIKE  '%$pesquisa%' ORDER BY nomeProduto";
$resultadoProduto = mysqli_query($conexao,$sqlProduto);

if (isset($_SESSION['idUsuario'])) {
    $idLogado = $_SESSION['idUsuario'];

    $sqlUsuario = "SELECT idUsuario, nomeUsuario FROM usuario WHERE idUsuario = ?";
    
    if ($stmt = mysqli_prepare($conexao, $sqlUsuario)) {
        
        mysqli_stmt_bind_param($stmt, "i", $idLogado);
        
        mysqli_stmt_execute($stmt);
        
        $resultadoUsuario = mysqli_stmt_get_result($stmt);
    }
} else {
    header("Location: loginUsuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php $titulo="Meu Perfil - Painel"; require_once ROOT_PATH . '/includes/head.php'; ?>
<body>
<main>
<?php require_once ROOT_PATH . '/includes/header.php'; ?>

<!-- -->
 
<!-- SEGUNDO -->
 
<div class="menuUsuario py-2">
    <div class="container my-5">

    <?php if ($_SESSION['nivel'] == 1) { ?>
                    <h2 class="fw-bold mb-4">Painel do Administrador</h2>
                <?php } else { ?>
                    <h2 class="fw-bold mb-4">Painel do Usuário</h2>
                <?php } ?>

    <div class="row g-4">

        <!-- Adicionar Produto -->
        <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>admin/produto/inserirProdutoForm.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            add_box
                        </span>
                        <h5 class="mt-3">Adicionar Produto</h5>
                        <p class="text-muted">
                            Cadastre um novo produto e compartilhe ofertas.
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Meus Produtos -->
        <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>admin/produto/meusProdutos.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            inventory_2
                        </span>
                        <h5 class="mt-3">Meus Produtos</h5>
                        <p class="text-muted">
                            Visualize e gerencie seus produtos cadastrados.
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Editar Perfil -->
         <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>admin/usuario/perfilUsuario.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            manage_accounts
                        </span>
                        <h5 class="mt-3">Editar Perfil</h5>
                        <p class="text-muted">
                            Atualize seus dados pessoais e foto.
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <?php if ($_SESSION['nivel']==1){ ?>
        <!-- Gerenciar -->
        <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>admin/categoria/gerenciarCategoria.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            manage_accounts
                        </span>
                        <h5 class="mt-3">Gerenciar Categorias</h5>
                        <p class="text-muted">
                            Gerencie as categorias disponíveis para os produtos.
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>admin/produto/gerenciarProduto.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            manage_accounts
                        </span>
                        <h5 class="mt-3">Gerenciar Produtos</h5>
                        <p class="text-muted">
                            Gerencie os produtos cadastrados no sistema.
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>admin/loja/gerenciarLoja.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            manage_accounts
                        </span>
                        <h5 class="mt-3">Gerenciar Lojas</h5>
                        <p class="text-muted">
                            Gerencie as lojas cadastradas no sistema.
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
        <!-- Favoritos
        <div class="col-md-6 col-lg-4">
            <a href="<?= BASE_URL ?>favoritos.php" class="text-decoration-none">
                <div class="card painel-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <span class="material-symbols-outlined painel-icone">
                            favorite
                        </span>
                        <h5 class="mt-3">Favoritos</h5>
                        <p class="text-muted">
                            Veja seus produtos favoritos.
                        </p>
                    </div>
                </div>
            </a>
        </div> -->
    </div>
</div>
</main>
<?php require_once ROOT_PATH . '/includes/footer.php'; ?>
</body>
</html>