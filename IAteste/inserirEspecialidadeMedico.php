<?php
include_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $especialidade = $_POST['especialidadeMedico'];

    $stmt = mysqli_prepare(
        $conexao,
        "INSERT INTO especialidade (especialidade_medico) VALUES (?)"
    );

    mysqli_stmt_bind_param($stmt, "s", $especialidade);

    if (mysqli_stmt_execute($stmt)) {
        echo "Cadastro realizado com sucesso";
        header("Refresh:3; url=exibirEspecialidadeTab.php");
        exit;
    } else {
        echo "Não foi possível realizar o cadastro. Erro: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
   


  <form action="" method="post">
    <div class="mb-3">
<label class="form-label" for="especialidadeMedico">Especialidade Médico</label>
<input class="form-control" type="text" id="especialidadeMedico" name="especialidadeMedico">

</div>
<div class="mb-3"><button type="button" id="btnIA" class="btn btn-primary">
    Buscar especialidades com IA
</button></div>



 <div class="mb-3">
<button type="submit">Salvar</button>

</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="testeIA.js"></script>
    
</form>
  </body>
</html>