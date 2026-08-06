<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();
exigirAdmin();

$idCategoria = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($idCategoria <= 0) {
    die("ID da categoria inválido.");
}

$sql = "SELECT * FROM categoria WHERE idCategoria = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idCategoria);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$resultado) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

$dadosCategoria = mysqli_fetch_assoc($resultado);

if (!$dadosCategoria) {
    die("Categoria não encontrada.");
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
</head>
<body>

<h1>Editar Categoria</h1>

<form action="atualizarCategoria.php" method="POST">

    <input
        type="hidden"
        name="idCategoria"
        value="<?php echo $dadosCategoria['idCategoria']; ?>">

    <input
        type="text"
        name="nomeCategoria"
        value="<?php echo htmlspecialchars($dadosCategoria['nomeCategoria']); ?>">

    <button type="submit">Salvar</button>

</form>

</body>
</html>
