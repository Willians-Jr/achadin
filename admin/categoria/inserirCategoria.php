<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();
exigirAdmin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nomeCategoria = trim($_POST['nomeCategoria'] ?? '');

        if (empty($nomeCategoria)) {
            die("Informe o nome da categoria.");
        }

        $sqlInsert = "INSERT INTO categoria (nomeCategoria) VALUES (?)";
        $stmt = mysqli_prepare($conexao, $sqlInsert);
        mysqli_stmt_bind_param($stmt, "s", $nomeCategoria);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            $_SESSION['mensagem'] = "Categoria cadastrada com sucesso!!";
            $_SESSION['tipoMensagem'] = "success";
            header("Location: gerenciarCategoria.php");
            exit;
        } else {
            throw new Exception(mysqli_stmt_error($stmt));
        }
    } catch (Throwable $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar a categoria. Erro: " . $e->getMessage();
        $_SESSION['tipoMensagem'] = "danger";
        header("Location: gerenciarCategoria.php");
        exit;
    }
}

$sql = "SELECT idCategoria, nomeCategoria FROM categoria";
$resultado = mysqli_query($conexao, $sql);
?>
