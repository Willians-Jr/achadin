<?php
include_once __DIR__ . '/includes/conexao.php';

$pesquisa="";

if (isset($_GET['pesquisa'])){
  $pesquisa=trim($_GET['pesquisa']);
  
}
$sql = "SELECT * FROM produto WHERE nomeProduto LIKE ?";

$stmt= mysqli_prepare($conexao, $sql);

$termo = "%" . $pesquisa . "%";

mysqli_stmt_bind_param($stmt, "s", $termo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<h2>Resultado da pesquisa: <?= htmlspecialchars($pesquisa) ?></h2>

<?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>

    <p><?= $produto['nomeProduto'] ?></p>
    <img src="<?= $produto['fotoProduto'] ?>"style="width: 50px"></img>

<?php } ?>
