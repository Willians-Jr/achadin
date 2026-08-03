<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduto = intval($_POST['idProduto'] ?? 0);
    $idCategoria = intval($_POST['idCategoria'] ?? 0);
    $idLoja = intval($_POST['idLoja'] ?? 0);
    $nomeProduto = trim($_POST['nomeProduto'] ?? '');
    $fotoProduto = trim($_POST['fotoAtual'] ?? '');

    if ($nomeProduto === '' || $idCategoria <= 0 || $idLoja <= 0 || $idProduto <= 0) {
        die("Todos os campos obrigatórios precisam ser preenchidos.");
    }

    if (isset($_FILES['fotoProduto']) && $_FILES['fotoProduto']['error'] == 0) {
        $pastaDestino = "../../assets/UPLOAD/";

        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        $imagemTmp = $_FILES['fotoProduto']['tmp_name'];
        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $imagemTmp);
        $extensoesPermitidas = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        if (isset($extensoesPermitidas[$mime])) {
            $extensao = $extensoesPermitidas[$mime];
            $novoNome = uniqid('produto_') . '.' . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;

            if (move_uploaded_file($imagemTmp, $caminhoCompleto)) {
                $fotoProduto = 'assets/UPLOAD/' . $novoNome;
            }
        }
    }

    $sqlUpdate = "UPDATE produto SET nomeProduto = ?, idCategoria = ?, idLoja = ?, fotoProduto = ? WHERE idProduto = ?";
    $stmt = mysqli_prepare($conexao, $sqlUpdate);
    mysqli_stmt_bind_param($stmt, "sissi", $nomeProduto, $idCategoria, $idLoja, $fotoProduto, $idProduto);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        echo "<script>
                alert('Produto atualizado com sucesso!');
                window.location='gerenciarProduto.php';
              </script>";
        exit;
    } else {
        error_log("Não foi possível realizar a edição: " . mysqli_error($conexao));
        mysqli_stmt_close($stmt);
        die("Não foi possível realizar a edição. Tente novamente mais tarde.");
    }
}

$idProduto = intval($_GET['id'] ?? 0);
if ($idProduto <= 0) {
    die("ID do produto inválido ou não informado.");
}

$sql = "SELECT * FROM produto WHERE idProduto = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idProduto);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $dados = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    mysqli_stmt_close($stmt);
    die("Produto não encontrado.");
}
?>
