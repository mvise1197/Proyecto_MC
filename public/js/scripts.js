<<<<<<< HEAD
function cargarSeccion(seccion) {
  const contenido = document.getElementById("contenido");

  let url = '';
  switch (seccion) {
    case "inicio":
      url = 'inicio.php';
      break;
    case "usuarios":
      url = 'listarpersonal.php'; // Asegúrate de que esta ruta sea correcta
      break;
    case "grados":
      url = 'listargrados.php';
      break;
      case "curso":
        url = 'listarcurso.php';
      break;
    case "estudiantes":
      url = 'listarestudiantes.php';
      break;
    case "asistencias":
      url = 'listarasistencias.php';
      break;
    case "notas":
      url = 'listarnotas.php';
      break;
    case "reportes":
      url = 'listarreportes.php';
      break;
    case "configuracion":
      url = 'configuracion.php';
      break;
    default:
      url = 'inicio.php';
  }

  // Realizar la solicitud AJAX para cargar solo el contenido
  fetch(url)
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      
      // Aquí asumimos que el contenido específico está dentro del elemento con ID 'contenido'
      const nuevoContenido = doc.getElementById('contenido').innerHTML;

      contenido.innerHTML = nuevoContenido;
    })
    .catch(error => {
      console.error('Error al cargar la sección:', error);
      contenido.innerHTML = `<h1>Error</h1><p>No se pudo cargar la sección.</p>`;
    });
}

//============== SCRIPT PARA CARGAR LOS FORMULARIOS "CREAR" ==============
function cargarFormularioCrear(tipoFormulario) {
  const contenido = document.querySelector('#contenido');
  
  // Limpia el contenido existente
  contenido.innerHTML = '';

  // Determina la URL del formulario basado en el tipo de formulario
  let urlFormulario = '';
  switch (tipoFormulario) {
    case 'personal':
      urlFormulario = 'create_personal.php';
      break;
    case 'estudiante':
      urlFormulario = 'create_estudiante.php';
      break;
    case 'curso':
      urlFormulario = 'create_curso.php';
      break;
    default:
      urlFormulario = 'create.php'; // Un valor por defecto en caso de que no se pase un tipo válido
  }

  // Cargar el formulario con fetch
  fetch(urlFormulario)
      .then(response => {
          if (!response.ok) {
              throw new Error('Error al cargar el formulario');
          }
          return response.text();
      })
      .then(html => {
          contenido.innerHTML = html;
      })
      .catch(error => {
          console.error('Error al cargar el formulario de creación:', error);
          contenido.innerHTML = `<h1>Error</h1><p>No se pudo cargar el formulario.</p>`;
      });
}


//============== SCRIPT PARA PONER EN FUNCIÓN EL MENÚ DESPLEGABLE ==============
=======
// Función para cargar las secciones del sistema
function cargarSeccion(seccion) {
    const contenido = document.getElementById("contenido");
  
    switch (seccion) {
      case "inicio":
        contenido.innerHTML = `
          <h1>Inicio</h1>
          <p>Bienvenido al sistema de gestión escolar.</p>
        `;
        break;
      case "instituciones":
        contenido.innerHTML = `
          <h1>Gestión de Instituciones</h1>
          <p>Aquí podrás administrar las instituciones registradas.</p>
        `;
        break;
      case "usuarios":
        contenido.innerHTML = `
          <h1>Gestión de Usuarios</h1>
          <p>Aquí podrás gestionar a los usuarios del sistema.</p>
        `;
        break;
      case "grados":
        contenido.innerHTML = `
          <h1>Gestión de Grados y Secciones</h1>
          <p>Aquí podrás administrar los grados y secciones disponibles.</p>
        `;
        break;
      case "estudiantes":
        contenido.innerHTML = `
          <h1>Gestión de Estudiantes</h1>
          <p>Aquí podrás registrar y consultar los estudiantes.</p>
        `;
        break;
      case "asistencias":
        contenido.innerHTML = `
          <h1>Gestión de Asistencias</h1>
          <p>Aquí podrás registrar y consultar las asistencias de los estudiantes.</p>
        `;
        break;
      case "notas":
        contenido.innerHTML = `
          <h1>Gestión de Notas</h1>
          <p>Aquí podrás registrar y consultar las notas de los estudiantes.</p>
          `;
        break;
      case "reportes":
        contenido.innerHTML = `
          <h1>Reportes</h1>
          <p>Aquí podrás generar reportes de notas y asistencias.</p>
        `;
        break;
      case "configuracion":
        contenido.innerHTML = `
          <h1>Configuración</h1>
          <p>Aquí podrás personalizar los parámetros del sistema.</p>
        `;
        break;
      default:
        contenido.innerHTML = `<h1>Error</h1><p>Sección no encontrada.</p>`;
        break;
    }
  }


// scripts.js
>>>>>>> 6f556ae15c98317bf436de74194cc90e02347285
document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.querySelector('.sidebar');

<<<<<<< HEAD
  // Alternar la clase 'active' en el menú al hacer clic en el botón
  menuToggle.addEventListener('click', (event) => {
    sidebar.classList.toggle('active');
    event.stopPropagation(); // Evitar que el evento se propague al documento
  });

  // Cerrar el menú al hacer clic fuera de él
  document.addEventListener('click', (event) => {
    // Verifica si el clic ocurrió fuera del menú y del botón
    if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
      sidebar.classList.remove('active');
    }
  });
});
=======
  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });
});
>>>>>>> 6f556ae15c98317bf436de74194cc90e02347285
