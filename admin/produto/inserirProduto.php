<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProduto = trim($_POST['nomeProduto'] ?? '');
    $idCategoria = intval($_POST['idCategoria'] ?? 0);
    $idLoja = intval($_POST['idLoja'] ?? 0);
    $idUsuario = intval($_SESSION['idUsuario'] ?? 0);
    $descricaoProduto = trim($_POST['descricaoProduto'] ?? '');
    $linkAfiliado = trim($_POST['linkAfiliado'] ?? '');

    if ($nomeProduto === '' || $idCategoria <= 0 || $idLoja <= 0 || $idUsuario <= 0) {
        die("Todos os campos obrigatórios precisam ser preenchidos.");
    }

    $fotoProduto = "";
    if (isset($_FILES["fotoProduto"]) && $_FILES["fotoProduto"]["error"] == 0) {
        $pastaDestino = "../../assets/UPLOAD/";
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        $imagemTmp = $_FILES["fotoProduto"]["tmp_name"];
        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $imagemTmp);
        $extensoesPermitidas = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        if (isset($extensoesPermitidas[$mime])) {
            $extensao = $extensoesPermitidas[$mime];
            $novoNome = uniqid("produto_") . "." . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;
            if (move_uploaded_file($imagemTmp, $caminhoCompleto)) {
                $fotoProduto = "assets/UPLOAD/" . $novoNome;
            }
        } else {
            die("Formato de imagem inválido.");
        }
    }

    $sqlInsert = "INSERT INTO produto (nomeProduto, idCategoria, idLoja, idUsuario, fotoProduto, descricaoProduto, linkAfiliado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sqlInsert);
    mysqli_stmt_bind_param($stmt, "siiisss", $nomeProduto, $idCategoria, $idLoja, $idUsuario, $fotoProduto, $descricaoProduto, $linkAfiliado);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        echo "<script>
                alert('Produto cadastrado com sucesso!');
                window.location='produtos.php';
              </script>";
        exit;
    } else {
        error_log("Erro ao cadastrar produto: " . mysqli_error($conexao));
        mysqli_stmt_close($stmt);
        die("Erro ao cadastrar produto. Tente novamente mais tarde.");
    }
}

$sql = "SELECT c.nomeCategoria, l.nomeLoja, u.nomeUsuario, p.nomeProduto, p.fotoProduto, p.descricaoProduto, p.linkAfiliado
        FROM produto p
        INNER JOIN categoria c ON p.idCategoria = c.idCategoria
        INNER JOIN loja l ON p.idLoja = l.idLoja
        INNER JOIN usuario u ON p.idUsuario = u.idUsuario
        ORDER BY p.idProduto DESC";

$resultado = mysqli_query($conexao, $sql);
?>
