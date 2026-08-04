<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

if (!isset($_SESSION['idUsuario'])) {
    header("Location: " . BASE_URL . "login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProduto = trim($_POST['nomeProduto'] ?? '');
    $idCategoria = intval($_POST['idCategoria'] ?? 0);
    $idLoja = intval($_POST['idLoja'] ?? 0);
    $precoProduto = str_replace(',', '.', trim($_POST['precoProduto'] ?? ''));
    $descricaoProduto = trim($_POST['descricaoProduto'] ?? '');
    $linkAfiliado = trim($_POST['linkAfiliado'] ?? '');
    $idUsuario = intval($_SESSION['idUsuario'] ?? 0);

    if ($nomeProduto === '' || $idCategoria <= 0 || $idLoja <= 0 || $idUsuario <= 0 || $precoProduto === '' || $descricaoProduto === '' || $linkAfiliado === '') {
        $_SESSION['mensagem'] = "Todos os campos obrigatórios precisam ser preenchidos.";
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: inserirProdutoForm.php");
        exit;
    }

    if (!is_numeric($precoProduto)) {
        $_SESSION['mensagem'] = "O preço do produto deve ser um número.";
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: inserirProdutoForm.php");
        exit;
    }

    $fotoProduto = "";
    if (isset($_FILES['fotoProduto']) && $_FILES['fotoProduto']['error'] === UPLOAD_ERR_OK) {
        $pastaDestino = ROOT_PATH . '/assets/UPLOAD/';
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

            if (!move_uploaded_file($imagemTmp, $caminhoCompleto)) {
                $_SESSION['mensagem'] = "Não foi possível fazer o upload da imagem.";
                $_SESSION['tipoMensagem'] = "danger";
                header("Location: inserirProdutoForm.php");
                exit;
            }

            $fotoProduto = 'assets/UPLOAD/' . $novoNome;
        } else {
            $_SESSION['mensagem'] = "Formato de imagem inválido.";
            $_SESSION['tipoMensagem'] = "danger";
            header("Location: inserirProdutoForm.php");
            exit;
        }
    }

    $sqlInsert = "INSERT INTO produto (nomeProduto, idCategoria, idLoja, idUsuario, fotoProduto, precoProduto, descricaoProduto, linkAfiliado)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sqlInsert);

    if ($stmt === false) {
        error_log("Erro ao preparar insert do produto: " . mysqli_error($conexao));
        $_SESSION['mensagem'] = "Erro ao cadastrar produto. Tente novamente mais tarde.";
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: inserirProdutoForm.php");
        exit;
    }

    $precoProduto = (float) $precoProduto;
    mysqli_stmt_bind_param($stmt, 'siiisdss', $nomeProduto, $idCategoria, $idLoja, $idUsuario, $fotoProduto, $precoProduto, $descricaoProduto, $linkAfiliado);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
        $_SESSION['tipoMensagem'] = "success";
        header("Location: produtos.php");
        exit;
    }

    error_log("Erro ao cadastrar produto: " . mysqli_error($conexao));
    mysqli_stmt_close($stmt);
    $_SESSION['mensagem'] = "Erro ao cadastrar produto. Tente novamente mais tarde.";
    $_SESSION['tipoMensagem'] = "danger";
    header("Location: inserirProdutoForm.php");
    exit;
}

$sql = "SELECT c.nomeCategoria, l.nomeLoja, u.nomeUsuario, p.nomeProduto, p.fotoProduto, p.precoProduto, p.descricaoProduto, p.linkAfiliado
        FROM produto p
        INNER JOIN categoria c ON p.idCategoria = c.idCategoria
        INNER JOIN loja l ON p.idLoja = l.idLoja
        INNER JOIN usuario u ON p.idUsuario = u.idUsuario
        ORDER BY p.idProduto DESC";

$resultado = mysqli_query($conexao, $sql);
?>
