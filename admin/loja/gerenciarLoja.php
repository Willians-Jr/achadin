<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
 
$pesquisaLoja = isset($_GET['pesquisaLoja']) ? $_GET['pesquisaLoja'] : '';
 
if ($pesquisaLoja) {
    $sql = "SELECT * FROM loja WHERE nomeLoja LIKE '%$pesquisaLoja%'
            ORDER BY nomeLoja ASC";
} else {
    $sql = "SELECT * FROM loja";
}
 
$resultado = mysqli_query($conexao, $sql);
 
if (!$resultado) {
    die("Erro ao buscar a loja: " . mysqli_error($conexao));
}
?>
 
<!doctype html>
<html lang="pt-br">
 
<?php
$titulo = "Gerenciar Loja";
require_once ROOT_PATH . '/includes/head.php';
?>
 
<body>
  <?php require_once ROOT_PATH . '/includes/header.php'; ?>
        <!-- Modal -->
<div class="modal fade" id="modalMensagem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <?php
                $tipo = $_SESSION['tipoMensagem'] ?? 'primary';

                switch ($tipo) {
                    case 'success':
                        $cor = 'bg-success';
                        $titulo = 'Sucesso';
                        break;

                    case 'warning':
                        $cor = 'bg-warning';
                        $titulo = 'Aviso';
                        break;

                    case 'danger':
                        $cor = 'bg-danger';
                        $titulo = 'Erro';
                        break;

                    default:
                        $cor = 'bg-primary';
                        $titulo = 'Mensagem';
                }
            ?>

            <div class="modal-header <?= $cor ?> text-white">
                <h5 class="modal-title"><?= $titulo ?></h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <?= $_SESSION['mensagem'] ?? '' ?>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-primary"
                    data-bs-dismiss="modal">

                    OK

                </button>

            </div>

        </div>
    </div>
</div>
<!-- Fim Modal -->

            
 
<main class="container py-5">
 
    <div class="d-flex justify-content-between align-items-center mb-4">
 
        <a href="<?= BASE_URL ?>" class="btn bg-dark-subtle">
            Menu Principal
</a>
 
        <h1 class="fw-bold mb-0">
            Lojas
</h1>
 
        <a href="inserirLojaForm.php" class="btn bg-dark-subtle">
            Inserir Loja
</a>
 
    </div>
 
    <div class="card shadow-lg border-0">
 
        <div class="card-body">
 
            <div class="col-lg-6 col-md-8 mb-4">
 
                <form method="GET">
 
                    <div class="d-flex gap-2">
 
                        <input
                            class="form-control"
                            type="search"
                            name="pesquisaLoja"
                            placeholder="Pesquisar loja..."
                            value="<?php echo htmlspecialchars($pesquisaLoja); ?>">
 
                        <button type="submit" class="btn bg-info-subtle">
                            Pesquisar
</button>
 
                    </div>
 
                </form>
 
            </div>
 
            <div class="table-responsive">
 
                <table class="table table-striped table-hover align-middle text-center">
 
                    <thead class="table-primary">
 
                        <tr>
<th>Nome</th>
<th>Logo</th>
<th colspan="2">Ações</th>
</tr>
 
                    </thead>
 
                    <tbody>
 
                        <?php while ($dados = mysqli_fetch_assoc($resultado)) { ?>
 
                        <tr>
 
                            <td>
<?php echo $dados['nomeLoja']; ?>
</td>
 
                            <td>
<img
                                    src="<?= BASE_URL ?>/assets/UPLOAD/<?php echo $dados['logoLoja']; ?>"
                                    alt="Logo da Loja"
                                    class="img-fluid rounded"
                                    style="max-width:100px; max-height:60px;">
</td>
 
                            <td width="120">
 
                                <a
                                    href="editarLoja.php?id=<?php echo $dados['idLoja']; ?>"
                                    class="btn bg-warning-subtle btn-sm">
 
                                    Alterar
 
                                </a>
 
                            </td>
 
                            <td width="120">
 
                                <a
                                    href="excluirLoja.php?id=<?php echo $dados['idLoja']; ?>"
                                    class="btn bg-danger-subtle btn-sm"
                                    onclick="return confirm('Deseja realmente excluir esta loja?')">
 
                                    Excluir
 
                                </a>
 
                            </td>
 
                        </tr>
 
                        <?php } ?>
 
                    </tbody>
 
                </table>
 
            </div>
 
        </div>
 
    </div>
 
</main>
<?php require_once ROOT_PATH . '/includes/footer.php'; ?>
<?php if (isset($_SESSION['mensagem'])): ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = new bootstrap.Modal(document.getElementById("modalMensagem"));
    modal.show();
});
</script>

<?php
unset($_SESSION['mensagem']);
unset($_SESSION['tipoMensagem']);
endif;
?>
</body>
</html>