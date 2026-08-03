<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeCategoria = trim($_POST['nomeCategoria']);

    if (empty($nomeCategoria)) {
        die("Informe o nome da categoria.");
    }

    $sqlInsert  = "INSERT INTO categoria (nomeCategoria) VALUES (?)";
    $stmtInsert = mysqli_prepare($conexao, $sqlInsert);
    mysqli_stmt_bind_param($stmtInsert, "s", $nomeCategoria);

    if (mysqli_stmt_execute($stmtInsert)) {
        // Antes redirecionava para este mesmo arquivo (que não tem HTML
        // para exibir) — agora vai para a listagem, onde dá pra confirmar
        // visualmente que a categoria foi criada.
        header("Location: gerenciarCategoria.php");
        exit;
    } else {
        echo "Erro ao cadastrar categoria.";
    }

    mysqli_stmt_close($stmtInsert);
}

$sql = "SELECT idCategoria, nomeCategoria FROM categoria";
$resultado = mysqli_query($conexao, $sql);
?>
