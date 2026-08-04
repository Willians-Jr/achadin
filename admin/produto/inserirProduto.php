<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: " . BASE_URL . "login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $precoProduto = $_POST['precoProduto'] ?? '';
        if (!is_numeric($precoProduto)) {
            throw new Exception("O preço do produto deve ser um número.");
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar produto: " . $e->getMessage();
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: inserirProduto.php");
        exit;
    }
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $idCategoria = $_POST['idCategoria'] ?? '';
    $idLoja = $_POST['idLoja'] ?? '';
    $idUsuario = $_SESSION['idUsuario'];
    $descricaoProduto = $_POST['descricaoProduto'] ?? '';
    $linkAfiliado = $_POST['linkAfiliado'] ?? '';

    $fotoProduto = "";

    
    if (isset($_FILES["fotoProduto"]) && $_FILES["fotoProduto"]["error"] == 0) {
        $pastaDestino = "../../assets/UPLOAD/";
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }
        $nomeOriginal = $_FILES["fotoProduto"]["name"];
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
        $extensoesPermitidas = ["jpg", "jpeg", "png", "gif"];
        
        if (in_array($extensao, $extensoesPermitidas)) {
            $novoNome = uniqid("produto_") . "." . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;
            if (move_uploaded_file($_FILES["fotoProduto"]["tmp_name"], $caminhoCompleto)) {
                $fotoProduto = "assets/UPLOAD/" . $novoNome;
            }
        }
    }

    $sqlInsert = "INSERT INTO produto (nomeProduto, idCategoria, idLoja, idUsuario, fotoProduto, precoProduto, descricaoProduto, linkAfiliado) 
                  VALUES ('$nomeProduto', '$idCategoria', '$idLoja', '$idUsuario', '$fotoProduto', '$precoProduto', '$descricaoProduto', '$linkAfiliado')";

    if (mysqli_query($conexao, $sqlInsert)) {
        echo "<script>
                alert('Produto cadastrado com sucesso!');
                window.location='produtos.php';
              </script>";
        exit;
    } else {
        echo "Erro ao cadastrar produto: " . mysqli_error($conexao) . "<br><br>";
    }
}

$sql = "SELECT c.nomeCategoria, l.nomeLoja, u.nomeUsuario, p.nomeProduto, p.fotoProduto, p.precoProduto, p.descricaoProduto, p.linkAfiliado
        FROM produto p
        INNER JOIN categoria c ON p.idCategoria = c.idCategoria
        INNER JOIN loja l ON p.idLoja = l.idLoja
        INNER JOIN usuario u ON p.idUsuario = u.idUsuario
        ORDER BY p.idProduto DESC";

$resultado = mysqli_query($conexao, $sql);
?>