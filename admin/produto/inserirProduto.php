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
    $descricaoProduto = trim($_POST['descricaoProduto'] ?? '');
    $linkAfiliado = trim($_POST['linkAfiliado'] ?? '');
    $idUsuario = intval($_SESSION['idUsuario'] ?? 0);

    $precoRaw = trim($_POST['precoProduto'] ?? '');
    $precoLimpo = str_replace('.', '', $precoRaw);
    $precoLimpo = str_replace(',', '.', $precoLimpo);

    if ($nomeProduto === '' || $idCategoria <= 0 || $idLoja <= 0 || $idUsuario <= 0 || $precoLimpo === '' || $descricaoProduto === '' || $linkAfiliado === '') {
        $_SESSION['mensagem'] = "Todos os campos obrigatórios precisam ser preenchidos.";
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: inserirProdutoForm.php");
        exit;
    }

    if (!is_numeric($precoLimpo)) {
        $_SESSION['mensagem'] = "O preço do produto deve ser um número válido.";
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: inserirProdutoForm.php");
        exit;
    }

    $precoProduto = (float) $precoLimpo;

    // Upload da Foto
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
            'image/png'  => 'png',
            'image/gif'  => 'gif'
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

    mysqli_stmt_bind_param(
        $stmt, 
        'siiisdss', 
        $nomeProduto, 
        $idCategoria, 
        $idLoja, 
        $idUsuario, 
        $fotoProduto, 
        $precoProduto, 
        $descricaoProduto, 
        $linkAfiliado
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
        $_SESSION['tipoMensagem'] = "success";
        header("Location: produtos.php");
        exit;
    } else {

        error_log("Erro no execute: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    $_SESSION['mensagem'] = "Erro ao cadastrar produto. Tente novamente mais tarde.";
    $_SESSION['tipoMensagem'] = "danger";
    header("Location: inserirProdutoForm.php");
    exit;
}