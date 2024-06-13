// Función para validar RUT chileno
function validarRut(rut) {
    // Formato: 12345678-9
    rut = rut.replace(/[^0-9kK]/g, ''); // Eliminar caracteres no numéricos
    if (!/^\d{7,8}([-]?\d{1})$/.test(rut)) return false; // Verificar formato
    var cuerpo = rut.slice(0, -1); // Extraer cuerpo del RUT
    var dv = rut.slice(-1).toUpperCase(); // Extraer DV
    var suma = cuerpo.split('').reverse().reduce(function (sum, d, i) {
      return sum + Number(d) * (i % 6 + 2);
    }, 0); // Calcular suma ponderada del cuerpo
    var dvCalc = (11 - suma % 11).toString(); // Calcular DV calculado
    if (dvCalc == '10') dvCalc = 'K'; // Reemplazar 10 por K
    if (dvCalc == '11') dvCalc = '0'; // Reemplazar 11 por 0
    return dvCalc === dv; // Validar DV
  }
  
  // Evento de submit del formulario
  $('#consultarUsuarioForm').submit(function (event) {
    event.preventDefault(); // Evitar el envío del formulario
    var rut = $('#rut').val(); // Obtener el valor del RUT ingresado
    if (rut.trim() === '') {
      // Mostrar mensaje de error si el RUT está vacío
      $('#rut').addClass('is-invalid');
      $('#rut').siblings('.invalid-feedback').show();
      return;
    }
    if (validarRut(rut)) {
      // Si el RUT es válido, realizar la consulta al servidor (aquí se debería hacer la consulta a la base de datos)
      // En este ejemplo, simularemos la consulta con datos estáticos
      // Supongamos que el usuario existe en la base de datos con los siguientes datos:
      var usuario = {
        rut: '12345678-9',
        nombre: 'Mariavictoria',
        tipo: 'Docente',
        prestamos: 5,
        deudas: [
          { titulo: 'Harry Potter', diasRetraso: 10, monto: '$5000' },
          { titulo: 'Cien años de soledad', diasRetraso: 5, monto: '$2500' }
        ]
      };
      // Mostrar los resultados en una tabla
      var resultadoHtml = `
        <h3>Resultados de la consulta</h3>
        <table class="table">
          <thead>
            <tr>
              <th>RUT</th>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Préstamos Realizados</th>
              <th>Deudas Pendientes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>${rut}</td>
              <td>${usuario.nombre}</td>
              <td>${usuario.tipo}</td>
              <td>${usuario.prestamos}</td>
              <td>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Título del Libro</th>
                      <th>Días de Retraso</th>
                      <th>Monto</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${usuario.deudas.map(deuda => `
                      <tr>
                        <td>${deuda.titulo}</td>
                        <td>${deuda.diasRetraso}</td>
                        <td>${deuda.monto}</td>
                      </tr>
                    `).join('')}
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <button class="btn btn-primary" onclick="realizarNuevaConsulta()">Realizar Nueva Consulta</button>
        <button class="btn btn-secondary" onclick="limpiarPantalla()">Limpiar Pantalla</button>
        <button class="btn btn-danger" onclick="salir()">Salir</button>
      `;
      $('#resultadoConsulta').html(resultadoHtml); // Mostrar resultados en la página
    } else {
      // Si el RUT no es válido, mostrar un mensaje de error
      $('#resultadoConsulta').html('<p>El RUT ingresado no es válido.</p>');
    }
  });
  
  // Función para realizar una nueva consulta
  function realizarNuevaConsulta() {
    $('#resultadoConsulta').html(''); // Limpiar los resultados anteriores
    $('#rut').val(''); // Limpiar el campo de RUT
    $('#rut').removeClass('is-invalid'); // Quitar clase de error del campo de RUT
    $('#rut').siblings('.invalid-feedback').hide(); // Ocultar mensaje de error del campo de RUT
  }
  
  // Función para limpiar la pantalla
  function limpiarPantalla() {
    $('#resultadoConsulta').html(''); // Limpiar los resultados anteriores
    $('#rut').removeClass('is-invalid'); // Quitar clase de error del campo de RUT
    $('#rut').siblings('.invalid-feedback').hide(); // Ocultar mensaje de error del campo de RUT
  }
  
  // Función para salir (redireccionar al index)
  function salir() {
    window.location.href = 'index.html'; // Redireccionar al index
  }
  