function añadirCantidadComprar() {
    let inputCantidad = document.getElementById("cantidadComprar");
    inputCantidad.innerHTML = parseInt(inputCantidad.innerHTML) + 1;
}

function quitarCantidadComprar() {
    let inputCantidad = document.getElementById("cantidadComprar");
    inputCantidad.innerHTML = parseInt(inputCantidad.innerHTML) - 1;
}