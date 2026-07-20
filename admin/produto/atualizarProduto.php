<?php
include_once __DIR__ . '/../../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCategoria = $_POST['idCategoria'] ?? 0;
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $idLoja = $_POST['idLoja'] ?? 0;

    if ($nomeProduto === '' || $idCategoria === 0 || $idLoja === 0) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }

    $sqlUpdate = "UPDATE produto SET nomeProduto = '$nomeProduto', idCategoria = $idCategoria, idLoja = $idLoja WHERE idProduto = $idProduto";

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "Produto atualizado com sucesso!";
        echo "<br><a href='inserirProduto.php'>Voltar para a listagem</a>";
        exit;
    } else {
        echo "Não foi possível realizar a edição: " . mysqli_error($conexao);
        exit;
    }
}

$idProduto = $_GET['id'] ?? 0;
$sql = "SELECT * FROM produto WHERE idProduto = $idProduto";
$result = mysqli_query($conexao, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $dados = mysqli_fetch_assoc($result);
} else {
    echo "Produto não encontrado.";
    exit;
}
?>