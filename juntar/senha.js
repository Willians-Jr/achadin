function mostrarRequisitos() {
  document.getElementById("requisitosSenha").style.display = "block";
}
function verificarSenha() {
  const campoSenha =
    document.getElementById("senhaNova") ||
    document.getElementById("senhaUsuario");
 
  const senha = campoSenha.value;
 
  const senhaForte = document.getElementById("senhaForte");
 
  let tamanho = senha.length >= 6;
  let maiuscula = /[A-Z]/.test(senha);
  let minuscula = /[a-z]/.test(senha);
  let numero = /[0-9]/.test(senha);
  let especial = /[!@#$%^&*(),.?":{}|<>]/.test(senha);
 
  atualizarItem(
    "reqTamanho",
    tamanho,
    "A senha precisa ter pelo menos 6 caracteres",
  );
  atualizarItem("reqMaiuscula", maiuscula, "Deve conter uma letra maiúscula");
  atualizarItem("reqMinuscula", minuscula, "Deve conter uma letra minúscula");
  atualizarItem("reqNumero", numero, "Deve conter um número");
  atualizarItem("reqEspecial", especial, "Deve conter um caractere especial");
 
  if (tamanho && maiuscula && minuscula && numero && especial) {
    senhaForte.value = "true";
  } else {
    senhaForte.value = "false";
  }
}
 
function atualizarItem(id, valido, texto) {
  const item = document.getElementById(id);
 
  if (valido) {
    item.innerHTML = "✅ " + texto;
    item.style.color = "green";
  } else {
    item.innerHTML = "❌ " + texto;
    item.style.color = "red";
  }
}
 
document
  .getElementById("formCadastro")
  .addEventListener("submit", function (e) {
    verificarSenha();
 
    if (document.getElementById("senhaForte").value !== "true") {
      e.preventDefault();
      alert("A senha ainda não atende todos os requisitos.");
    }
  });