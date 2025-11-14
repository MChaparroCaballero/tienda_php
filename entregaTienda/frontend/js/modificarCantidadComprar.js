function añadirCantidadComprar() {
    let inputCantidad = document.getElementById("cantidad");
    let cantidad = parseInt(inputCantidad.innerHTML);
    inputCantidad.innerHTML = cantidad;
    inputCantidad.value=cantidad;
}

function quitarCantidadComprar() {
    let inputCantidad = document.getElementById("cantidad");
    let cantidad = parseInt(inputCantidad.innerHTML);

    if(cantidad>0){
        cantidad--;
        inputCantidad.innerHTML = cantidad;
        inputCantidad.value=cantidad;
    }else{
        alert("No se puede reducir más la cantidad");
    }
}