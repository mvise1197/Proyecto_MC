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
document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.querySelector('.sidebar');

  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });
});
