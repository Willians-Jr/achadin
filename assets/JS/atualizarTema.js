const botao = document.getElementById("btnTema");
 
if(localStorage.getItem("tema") === "escuro"){
    document.body.classList.add("dark-mode");
    document.documentElement.setAttribute("data-bs-theme","dark");
}
 
botao.addEventListener("click", ()=>{
 
    document.body.classList.toggle("dark-mode");
 
    if(document.body.classList.contains("dark-mode")){
        document.documentElement.setAttribute("data-bs-theme","dark");
        localStorage.setItem("tema","escuro");
    }else{
        document.documentElement.setAttribute("data-bs-theme","light");
        localStorage.setItem("tema","claro");
    }
 
});
 
const botaoTema = document.getElementById("btnTema");
const iconeTema = document.getElementById("iconeTema");
 
// Carrega o tema salvo
if (localStorage.getItem("tema") === "escuro") {
    document.body.classList.add("dark-theme");
}
 
function atualizarTema() {
 
    const temaEscuro = document.body.classList.contains("dark-theme");
 
    if (temaEscuro) {
        iconeTema.textContent = "light_mode";
        localStorage.setItem("tema", "escuro");
    } else {
        iconeTema.textContent = "dark_mode";
        localStorage.setItem("tema", "claro");
    }
 
}
 
botaoTema.addEventListener("click", () => {
 
    document.body.classList.toggle("dark-theme");
 
    atualizarTema();
 
});
 
atualizarTema();