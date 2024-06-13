function confirmarAgregarAutor() {
    var nombre = document.getElementById('nombre').value;
    var apellido = document.getElementById('apellido').value;
    var nacionalidad = document.getElementById('nacionalidad').value;

    Swal.fire({
        title: '¿Estás seguro de agregar el siguiente autor?',
        html: `<p>Nombre: ${nombre}</p>
               <p>Apellido: ${apellido}</p>
               <p>Nacionalidad: ${nacionalidad}</p>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Agregar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('agregarAutorForm').submit();
        }
    });
}