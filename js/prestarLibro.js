$(document).ready(function() {
  // Función para calcular la fecha de devolución
  $("#anioInicio, #mesInicio, #diaInicio").change(function() {
    var tipoUsuario = $("#tipoUsuario").val();
    var mesInicio = $("#mesInicio").val();
    var diaInicio = $("#diaInicio").val();
    var anioInicio = $("#anioInicio").val();

    if (mesInicio && diaInicio && anioInicio) {
      var fechaInicio = new Date(anioInicio, mesInicio - 1, diaInicio);
      if (tipoUsuario === "docente") {
        // Sumar 7 días para docentes
        fechaInicio.setDate(fechaInicio.getDate() + 7);
      } else {
        // Sumar 5 días para alumnos
        fechaInicio.setDate(fechaInicio.getDate() + 5);
      }

      var dd = String(fechaInicio.getDate()).padStart(2, '0');
      var mm = String(fechaInicio.getMonth() + 1).padStart(2, '0');
      var yyyy = fechaInicio.getFullYear();

      var fechaDevolucion = yyyy + '-' + mm + '-' + dd;
      $("#fechaDevolucion").val(fechaDevolucion);
    }
  });

  // Función para validar campos no vacíos
  function validarCamposVacios() {
    var camposVacios = false;
    $("input, select").each(function() {
      if (!$(this).val()) {
        camposVacios = true;
        return false;
      }
    });
    return camposVacios;
  }

  // Función para validar campos con el formato correcto
  function validarFormatoCampos() {
    var formatoCorrecto = true;
    var rutUsuario = $("#rutUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var apellidoUsuario = $("#apellidoUsuario").val();
    var diaInicio = $("#diaInicio").val();
    var mesInicio = $("#mesInicio").val();
    var anioInicio = $("#anioInicio").val();

    if (!/^\d{1,2}\.\d{3}\.\d{3}(-\d|k)$/i.test(rutUsuario)) {
      formatoCorrecto = false;
    }
    if (!/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreUsuario) || !/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test(apellidoUsuario)) {
      formatoCorrecto = false;
    }
    if (parseInt(diaInicio) < 1 || parseInt(diaInicio) > 31) {
      formatoCorrecto = false;
    }
    if (parseInt(anioInicio) < 1900 || parseInt(anioInicio) > (new Date()).getFullYear()) {
      formatoCorrecto = false;
    }
    return formatoCorrecto;
  }

  // Función para mostrar mensajes de error
  function mostrarMensajeError(mensaje) {
    $("#mensajeError").remove(); // Limpiar mensajes anteriores
    $("#prestamo-form").prepend("<div class='alert alert-danger' id='mensajeError'>" + mensaje + "</div>");
  }

  // Función para registrar el préstamo
  $("#btnRealizarPrestamo").click(function() {
    if (validarCamposVacios()) {
      mostrarMensajeError("Debe completar todos los campos del formulario.");
      return;
    }
    if (!validarFormatoCampos()) {
      mostrarMensajeError("Por favor, complete el formulario correctamente.");
      return;
    }

    // Si se llega aquí, todos los campos están completos y tienen el formato correcto
    // Aquí se podría agregar la lógica para enviar los datos al servidor
    // utilizando AJAX o fetch para registrar el préstamo en la base de datos.
    // Por ejemplo:
    // $.post("url_del_servidor", { rutUsuario: rutUsuario, nombreUsuario: nombreUsuario, ... }, function(data) {
    //    console.log("Préstamo registrado:", data);
    // });

    // Mostrar mensaje de éxito
    $("#mensajeError").remove(); // Limpiar mensajes anteriores
    $("#prestamo-form").prepend("<div class='alert alert-success'>El préstamo se ha registrado exitosamente.</div>");
  });

  // Función para limpiar la pantalla
  $("#btnLimpiarPantalla").click(function() {
    $("#mensajeError").remove(); // Limpiar mensajes de error
    $("#prestamo-form")[0].reset(); // Limpiar el formulario
    $("#fechaDevolucion").val(""); // Limpiar fecha de devolución
  });
 
});

// Obtener los elementos relevantes del DOM
var tipoUsuarioInput = document.getElementById('tipoUsuario');
var fechaPrestamoInput = document.getElementById('fechaPrestamo');
var fechaDevolucionInput = document.getElementById('fechaDevolucion');

// Función para calcular la fecha de devolución
function calcularFechaDevolucion() {
var tipoUsuario = tipoUsuarioInput.value;
var fechaPrestamoValue = fechaPrestamoInput.value;

// Verificar si la fecha de préstamo tiene un valor válido
if (fechaPrestamoValue) {
  var fechaPrestamo = new Date(fechaPrestamoValue);
  if (!isNaN(fechaPrestamo.getTime())) { // Verificar si la fecha es válida
    var fechaDevolucion = new Date(fechaPrestamo); // Crear una copia de la fecha

    // Verificar el tipo de usuario seleccionado y sumar días correspondientes
    if (tipoUsuario === 'alumno') {
      fechaDevolucion.setDate(fechaDevolucion.getDate() + 8); // 7 días para estudiantes
    } else if (tipoUsuario === 'docente') {
      fechaDevolucion.setDate(fechaDevolucion.getDate() + 21); // 20 días para docentes
    } else {
      fechaDevolucion = null; // Otro tipo de usuario, no asignar días de devolución
    }

    // Actualizar el valor del campo de fecha de devolución si se asignan días
    if (fechaDevolucion !== null) {
      var year = fechaDevolucion.getFullYear();
      var month = ('0' + (fechaDevolucion.getMonth() + 1)).slice(-2);
      var day = ('0' + fechaDevolucion.getDate()).slice(-2);
      var fechaFormateada = year + '-' + month + '-' + day;
      fechaDevolucionInput.value = fechaFormateada;
    } else {
      fechaDevolucionInput.value = ''; // Limpiar el campo de fecha de devolución
    }
  } else {
    alert('La fecha ingresada en el campo de préstamo no es válida.');
  }
}
}

// Escuchar el evento input en el campo de fecha de préstamo
fechaPrestamoInput.addEventListener('input', calcularFechaDevolucion);

// También, escuchar el cambio de tipo de usuario para actualizar la fecha de devolución
tipoUsuarioInput.addEventListener('change', calcularFechaDevolucion);

document.addEventListener("DOMContentLoaded", function () { //se asegura que todos los elementos del HTML esten disponibles para ser manipulados
const autorSelect = document.getElementById("tipoAutor"); //trae el input de autor
const libroSelect = document.getElementById("tipoLibro"); //trae el input de libro

fetch("json/autores.json") //el metodo fetch es para cargar archivos json
    .then(response => response.json())
    .then(data => {
        data.autores.forEach(autor => {
            const option = document.createElement("option"); //itera por cada objeto autor dentro del json y crea una opcion para elejir
            option.textContent = autor.nombre;
            autorSelect.appendChild(option);
        });

        autorSelect.addEventListener("change", function () { //al seleccinar un autor se ejecuta este codigo, y obtiene los libros correspondientes al autor seleccionado
            const autorSeleccionado = this.value;
            const librosAutor = data.autores.find(autor => autor.nombre === autorSeleccionado).libros;

            libroSelect.innerHTML = "<option selected>Seleccione un libro</option>";
            librosAutor.forEach(libro => {
                const option = document.createElement("option");
                option.textContent = libro.titulo;
                libroSelect.appendChild(option);
            });
        });
    })
    .catch(error => {
        console.error("Error al cargar el JSON:", error);
        messageDiv.textContent = "Error al cargar los datos. Por favor, intenta nuevamente más tarde.";
    });

});

var rutInput = document.getElementById('rutUsuario');
var resultado = document.getElementById('resultado');

// Evento blur para validar el RUT cuando se sale del input
rutInput.addEventListener('blur', function() {
// Obtener el valor del input del RUT
var rutValor = rutInput.value;

// Verificar si cumple con el formato esperado
var rutRegex = /^[0-9]{7,8}-[0-9Kk]$/;
if (!rutRegex.test(rutValor)) {
  resultado.innerText = 'Formato incorrecto';
  return;
}

// Separar el RUT y el dígito verificador
var rutPartes = rutValor.split('-');
var rutNumeros = rutPartes[0];
var verificador = rutPartes[1].toUpperCase();

// Calcular el dígito verificador esperado
var rutSum = 0;
var multiplier = 2;

for (var i = rutNumeros.length - 1; i >= 0; i--) {
  rutSum += parseInt(rutNumeros[i]) * multiplier;
  multiplier = multiplier === 7 ? 2 : multiplier + 1;
}

var expectedVerificador = 11 - (rutSum % 11);
if (expectedVerificador === 11) expectedVerificador = 0;
else if (expectedVerificador === 10) expectedVerificador = 'K';

// Comparar el dígito verificador calculado con el ingresado
if (verificador === expectedVerificador.toString()) {
  resultado.innerText = 'RUT válido.';
} else {
  resultado.innerText = 'RUT inválido.';
}
});
