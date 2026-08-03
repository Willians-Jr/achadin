<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomeCategoria = trim($_POST['nomeCategoria'] ?? '');

    if ($nomeCategoria === '') {
        die("Informe o nome da categoria.");
    }

    $sqlInsert = "INSERT INTO categoria (nomeCategoria) VALUES (?)";
    $stmt = mysqli_prepare($conexao, $sqlInsert);
    mysqli_stmt_bind_param($stmt, "s", $nomeCategoria);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        echo "<script>
                alert('Categoria cadastrada com sucesso!');
                window.location='inserirCategoriaForm.php';
              </script>";
        exit;
    } else {
        error_log("Erro ao cadastrar categoria: " . mysqli_error($conexao));
        mysqli_stmt_close($stmt);
        die("Erro ao cadastrar categoria. Tente novamente mais tarde.");
    }
}

$sql = "SELECT idCategoria, nomeCategoria FROM categoria";
$resultado = mysqli_query($conexao, $sql);
?>
