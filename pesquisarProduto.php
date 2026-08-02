<?php

require_once __DIR__ . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

$pesquisa = "";

if (isset($_GET['pesquisa'])) {
    $pesquisa = trim($_GET['pesquisa']);
}

if ($pesquisa == "") {
    $erro = "Digite algo para pesquisar!";
} else {

    $sqlCategorias = "SELECT * FROM categoria ORDER BY nomeCategoria";
    $resCategorias = mysqli_query($conexao, $sqlCategorias);

    // Monta a query de forma incremental, mantendo tipos e valores em paralelo
    // para o bind_param nunca ficar dessincronizado com os "?" do SQL.
    $sql    = "SELECT * FROM produto WHERE nomeProduto LIKE ?";
    $tipos  = "s";
    $termo  = "%" . $pesquisa . "%";
    $params = [$termo];

    if (isset($_GET['categoria']) && is_array($_GET['categoria']) && count($_GET['categoria']) > 0) {
        $idsCategorias = array_values(array_filter(array_map('intval', $_GET['categoria'])));

        if (!empty($idsCategorias)) {
            $placeholders = implode(',', array_fill(0, count($idsCategorias), '?'));
            $sql   .= " AND idCategoria IN ($placeholders)";
            $tipos .= str_repeat('i', count($idsCategorias));
            array_push($params, ...$idsCategorias);
        }
    }

    if (isset($_GET['precoMax']) && is_numeric($_GET['precoMax'])) {
        $sql     .= " AND precoProduto <= ?";
        $tipos   .= "d";
        $params[] = (float) $_GET['precoMax'];
    }

    // Whitelist de ordenação — nunca interpolar $_GET['ordenar'] direto no SQL.
    $colunasOrdenacao = [
        'precoASC'  => 'precoProduto ASC',
        'precoDESC' => 'precoProduto DESC',
        'desconto'  => 'descontoProduto DESC',
        'cashback'  => 'cashbackProduto DESC',
        'recentes'  => 'idProduto DESC',
    ];
    $ordenar = $_GET['ordenar'] ?? '';
    $orderBy = $colunasOrdenacao[$ordenar] ?? 'nomeProduto ASC';
    $sql .= " ORDER BY $orderBy";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, $tipos, ...$params);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
}

// =========================================================================
// GRAVAR NO HISTÓRICO ATRAVÉS DA NAVEGAÇÃO DA PESQUISA
// Só grava se houver um usuário de fato logado — antes, cliques anônimos
// eram atribuídos ao usuário de ID 1 por padrão, poluindo o histórico dele.
// =========================================================================
if (isset($_GET['id']) && isset($_SESSION['idUsuario'])) {
    $idProdutoAtual  = intval($_GET['id']);
    $idUsuarioLogado = intval($_SESSION['idUsuario']);

    $sqlInsert  = "INSERT INTO historicoclique (idUsuario, idProduto) VALUES (?, ?)";
    $stmtInsert = mysqli_prepare($conexao, $sqlInsert);
    mysqli_stmt_bind_param($stmtInsert, "ii", $idUsuarioLogado, $idProdutoAtual);
    mysqli_stmt_execute($stmtInsert);
    mysqli_stmt_close($stmtInsert);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php $titulo = "Resultado da Pesquisa - TopAchados";
require_once ROOT_PATH . '/includes/head.php'; ?>
<body>
<main>
   <?php require_once ROOT_PATH . '/includes/header.php'; ?>
   <div class="container py-5">

    <h1 class="fw-bold display-5">Resultado da pesquisa</h1>

    <p class="text-secondary">
        Descubra ofertas e cupons para os produtos mais desejados.
    </p>

    <div class="d-flex gap-3 flex-wrap my-4">
        <button class="btn btn-primary rounded-pill">Em Alta</button>
        <button class="btn btn-outline-secondary rounded-pill">Eletrônicos</button>
        <button class="btn btn-outline-secondary rounded-pill">Informática</button>
        <button class="btn btn-outline-secondary rounded-pill">Smartphones</button>
        <button class="btn btn-outline-secondary rounded-pill">Games</button>
    </div>

    <?php if (isset($erro)) { ?>

        <div class="alert alert-warning" role="alert">
            <?= htmlspecialchars($erro) ?>
        </div>

    <?php } else { ?>

        <div class="row">

            <aside class="col-lg-3 mb-4">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-4">Filtros</h5>

                        <form method="GET">
                            <input type="hidden" name="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>">

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Categoria</label>

                                <?php while ($categoria = mysqli_fetch_assoc($resCategorias)) { ?>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="categoria[]"
                                            value="<?= (int) $categoria['idCategoria'] ?>"
                                            <?= in_array($categoria['idCategoria'], $_GET['categoria'] ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label">
                                            <?= htmlspecialchars($categoria['nomeCategoria']) ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Faixa de preço</label>
                                <input
                                    type="range"
                                    name="precoMax"
                                    min="0"
                                    max="1000"
                                    value="<?= htmlspecialchars($_GET['precoMax'] ?? 1000) ?>"
                                    class="form-range">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Cashback</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Acima de 2%</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Acima de 5%</label>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">
                                Aplicar filtros
                            </button>
                        </form>

                    </div>

                </div>

            </aside>

            <div class="col-lg-9">

                <?php if (mysqli_num_rows($resultado) > 0) { ?>

                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

                        <p class="text-secondary mb-2 mb-lg-0">
                            <?= mysqli_num_rows($resultado) ?> produtos encontrados
                        </p>

                        <div class="d-flex align-items-center gap-2">
                            <label class="fw-semibold mb-0">Ordenar por</label>

                            <select
                                name="ordenar"
                                class="form-select"
                                style="width:220px;"
                                onchange="atualizarOrdenacao(this.value)">

                                <option value="relevancia" <?= $ordenar == '' ? 'selected' : '' ?>>Mais relevantes</option>
                                <option value="precoASC" <?= $ordenar == 'precoASC' ? 'selected' : '' ?>>Menor preço</option>
                                <option value="precoDESC" <?= $ordenar == 'precoDESC' ? 'selected' : '' ?>>Maior preço</option>
                                <option value="desconto" <?= $ordenar == 'desconto' ? 'selected' : '' ?>>Maior desconto</option>
                                <option value="cashback" <?= $ordenar == 'cashback' ? 'selected' : '' ?>>Maior cashback</option>
                                <option value="recentes" <?= $ordenar == 'recentes' ? 'selected' : '' ?>>Mais recentes</option>
                            </select>
                        </div>

                    </div>

                    <!-- CARDS -->
                    <div class="row g-4">

                        <?php while ($produto = mysqli_fetch_assoc($resultado)) {
                            $preco     = isset($produto['precoProduto']) ? (float) $produto['precoProduto'] : 0;
                            $desconto  = isset($produto['descontoProduto']) ? (int) $produto['descontoProduto'] : 0;
                            $cashback  = isset($produto['cashbackProduto']) ? (int) $produto['cashbackProduto'] : 0;
                        ?>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                <div class="card h-100 shadow-sm">

                                    <div class="position-relative">

                                        <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>"
                                           target="_blank"
                                           rel="noopener"
                                           onclick="window.location.href='?<?= http_build_query(array_merge($_GET, ['id' => $produto['idProduto']])) ?>';"
                                           class="link-produto-vitrine">
                                            <img src="<?= BASE_URL ?><?= !empty($produto['fotoProduto']) ? htmlspecialchars($produto['fotoProduto']) : 'sem-imagem.png' ?>"
                                                 class="card-img-top img-fluid p-3"
                                                 alt="<?= htmlspecialchars($produto['nomeProduto']) ?>">
                                        </a>

                                        <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">
                                            <a href="#" class="text-dark">
                                                <span class="material-symbols-outlined">favorite</span>
                                            </a>
                                            <a href="#" class="text-dark">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                    <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5"/>
                                                </svg>
                                            </a>
                                        </div>

                                    </div>

                                    <div class="card-body">

                                        <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>"
                                           target="_blank"
                                           rel="noopener"
                                           onclick="window.location.href='?<?= http_build_query(array_merge($_GET, ['id' => $produto['idProduto']])) ?>';"
                                           class="link-produto-vitrine">
                                            <h5 class="fw-bold">
                                                <?= htmlspecialchars($produto['nomeProduto'], ENT_QUOTES, 'UTF-8') ?>
                                            </h5>
                                        </a>

                                        <p class="text-secondary">
                                            A partir de R$ <?= number_format($preco, 2, ',', '.') ?>
                                        </p>

                                        <?php if ($desconto > 0) { ?>
                                            <span class="badge bg-success">Até <?= $desconto ?>% OFF</span>
                                        <?php } ?>

                                        <?php if ($cashback > 0) { ?>
                                            <span class="badge bg-success-subtle text-success">Até <?= $cashback ?>% Cashback</span>
                                        <?php } ?>

                                    </div>

                                </div>
                            </div>

                        <?php } ?>

                    </div>

                <?php } else { ?>

                    <div class="alert alert-info">
                        Nenhum produto encontrado para "<?= htmlspecialchars($pesquisa) ?>".
                    </div>

                <?php } ?>

            </div>

        </div>

    <?php } ?>

</div>
</main>
<?php require_once ROOT_PATH . '/includes/footer.php'; ?>

<script>
function atualizarOrdenacao(valor) {
    const params = new URLSearchParams(window.location.search);
    params.set('ordenar', valor);
    window.location.search = params.toString();
}
</script>

</body>
</html>