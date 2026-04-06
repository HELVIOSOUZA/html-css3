function mostrarGabarito(id){
    var elemento = document.getElementById(id);

    if(elemento.style.display === "block"){
        elemento.style.display = "none";
    } else {
        elemento.style.display = "block";
    }
}
function mostrarGabarito(id){
    let el = document.getElementById(id);
    el.style.display = el.style.display === "block" ? "none" : "block";
}