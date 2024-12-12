
  function cargarSeccion(seccion) {
    const contenido = document.getElementById("contenido");

    let url = '';
    switch (seccion) {
      case "inicio":
        url = 'inicio.php';
        break;
      case "personal":
        url = 'listarpersonal.php';
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
      case "nota":
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
      case 'grados':
        urlFormulario = 'create_grado.php';
        break;
      case 'curso':
        urlFormulario = 'create_curso.php';
        break;
      case 'estudiante':
        urlFormulario = 'create_estudiante.php';
        break;
      case 'asistencia':
        urlFormulario = 'create_asistencia.php';
        break;
        case 'nota':
          urlFormulario = 'create_nota.php';
          break;
      case 'reportes':
        urlFormulario = 'create_reportes.php';
        break;
      default:
        urlFormulario = 'create.php';
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
  // scripts.js
  document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');

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