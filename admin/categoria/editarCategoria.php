
<?php
include_once __DIR__ . '/../../includes/conexao.php';



$dadosCategoria = mysqli_fetch_assoc($resultado);


$idCategoria = (int) $_GET['idCategoria'];

$sql = "SELECT * FROM categoria WHERE idCategoria = $idCategoria";

$resultado = mysqli_query($conexao, $sql);
$dadosCategoria = mysqli_fetch_assoc($resultado);

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Categoria</title>
  </head>
  <body>
    <h1>Editar Categoria</h1>
    <form action="atualizarCategoria.php" method="POST">
      <input type="hidden" id="idCategoria" name="idCategoria" value="<?php echo $dadosCategoria['idCategoria']; ?>" />

      <label for="nomeCategoria">Nome:</label>
      <input type="text" id="nomeCategoria" name="nomeCategoria" value="<?php echo $dadosCategoria['nomeCategoria']; ?>" required />
      <br />
      <button type="submit">Atualizar Categoria</button>
    </form>
  </body>
</html>
