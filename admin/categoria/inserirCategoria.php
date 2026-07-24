<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeCategoria = trim($_POST['nomeCategoria']);

    if (empty($nomeCategoria)) {
        die("Informe o nome da categoria.");
    }

    $nomeCategoria = mysqli_real_escape_string($conexao, $nomeCategoria);

    $sqlInsert = "INSERT INTO categoria (nomeCategoria)
                  VALUES ('$nomeCategoria')";

    if (mysqli_query($conexao, $sqlInsert)) {

        header("Location: inserirCategoria.php");
        exit;

    } else {

        echo "Erro ao cadastrar categoria: " . mysqli_error($conexao);

    }

}

$sql = "SELECT idCategoria, nomeCategoria
        FROM categoria";

$resultado = mysqli_query($conexao, $sql);
?>