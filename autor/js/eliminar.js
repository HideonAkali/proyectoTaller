document.getElementById('formEliminarAutor').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir la sumisión del formulario por defecto

    var select = document.getElementById('autorID');
    var selectedOption = select.options[select.selectedIndex];
    var autorNombre = selectedOption.textContent;

    Swal.fire({
        title: "¿Estás seguro?",
        text: `¡Eliminarás a "${autorNombre}" y no podrás revertir esto!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "¡Eliminado!",
                text: `${autorNombre} ha sido eliminado.`,
                icon: "success"
            }).then(() => {
                // Continuar con la sumisión del formulario
                event.target.submit();
            });
        }
    });
});