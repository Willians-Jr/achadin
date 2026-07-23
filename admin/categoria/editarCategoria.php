<?php
include_once __DIR__ . '/../../includes/conexao.php';


$idCategoria = isset($_GET['idCategoria']) ? (int) $_GET['idCategoria'] : 0;

if ($idCategoria <= 0) {
    die("ID da categoria inválido.");
}

$sql = "SELECT * FROM categoria WHERE idCategoria = $idCategoria";

$resultado = mysqli_query($conexao, $sql);

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
