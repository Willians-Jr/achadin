<?php
include_once __DIR__ . '/../../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduto = $_POST['idProduto'] ?? 0;
    $idCategoria = $_POST['idCategoria'] ?? 0;
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $idLoja = $_POST['idLoja'] ?? 0;

    $fotoProduto = $_POST['fotoAtual'] ?? ''; 

    if ($nomeProduto === '' || $idCategoria == 0 || $idLoja == 0 || $idProduto == 0) {
        echo "Todos os campos obrigatórios precisam ser preenchidos.";
        exit;
    }

    if (isset($_FILES['fotoProduto']) && $_FILES['fotoProduto']['error'] == 0) {
        $pastaDestino = "../../assets/UPLOAD/";

        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        $nomeOriginal = $_FILES['fotoProduto']['name'];
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $extensoesPermitidas)) {
            $novoNome = uniqid('produto_') . '.' . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;

            if (move_uploaded_file($_FILES['fotoProduto']['tmp_name'], $caminhoCompleto)) {
                $fotoProduto = 'assets/UPLOAD/' . $novoNome;
            }
        }
    }

    $sqlUpdate = "UPDATE produto SET 
                    nomeProduto = '$nomeProduto', 
                    idCategoria = $idCategoria, 
                    idLoja = $idLoja, 
                    fotoProduto = '$fotoProduto' 
                  WHERE idProduto = $idProduto";

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "<script>
                alert('Produto atualizado com sucesso!');
                window.location='gerenciarProduto.php';
              </script>";
        exit;
    } else {
        echo "Não foi possível realizar a edição: " . mysqli_error($conexao);
        exit;
    }
}

$idProduto = $_GET['id'] ?? 0;

if ($idProduto == 0) {
    echo "ID do produto inválido ou não informado.";
    exit;
}

$sql = "SELECT * FROM produto WHERE idProduto = $idProduto";
$result = mysqli_query($conexao, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $dados = mysqli_fetch_assoc($result);
} else {
    echo "Produto não encontrado.";
    exit;
}
?>