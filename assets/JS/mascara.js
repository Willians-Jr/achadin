$(document).ready(function () {
  $("#cpf").mask("000.000.000-00", { reverse: false });
  $("#tel").mask("(00)00000-0000", { reverse: false });
  $("#cep").mask("00000-000", { reverse: false });
  $("#valor").mask("###.###.##0,00", { reverse: false });
  $("#data").mask("00/00/0000", { reverse: false });
});
