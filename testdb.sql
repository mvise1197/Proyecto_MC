-- Crear la base de datos "prueba_colegio_mc"
CREATE DATABASE IF NOT EXISTS testdb;
USE testdb;

-- Tabla: Tipo_Usuario (Roles de usuario)
CREATE TABLE Tipo_Usuario (
    idTipo_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Tipo VARCHAR(20) NOT NULL -- Ejemplo: Administrador, Docente, Padre, Usuario
);

-- Tabla: Institución
CREATE TABLE Institucion (
    idInstitucion INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(85) NOT NULL,
    Nivel VARCHAR(45) NOT NULL,
    Codigo_Modular VARCHAR(10) NOT NULL UNIQUE,
    Logo VARCHAR(75)
);

-- Tabla: Personal (Incluye usuarios como docentes o administrativos)
CREATE TABLE Personal (
    idPersonal INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(55) NOT NULL,
    Apellidos VARCHAR(75) NOT NULL,
    Usuario VARCHAR(45) NOT NULL UNIQUE,
    Clave VARCHAR(255) NOT NULL, -- Clave encriptada
    Correo VARCHAR(100) NOT NULL UNIQUE, -- Correo electrónico del usuario
    idTipo_Usuario INT NOT NULL,
    idInstitucion INT NOT NULL,
    token VARCHAR(255) NULL, -- Token para restablecer la contraseña
    token_expiration DATETIME NULL, -- Fecha de expiración del token
    FOREIGN KEY (idTipo_Usuario) REFERENCES Tipo_Usuario(idTipo_Usuario),
    FOREIGN KEY (idInstitucion) REFERENCES Institucion(idInstitucion)
);

-- Tabla: Grado (Clases o grados académicos)
CREATE TABLE Grado (
    idGrado INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Grado VARCHAR(45) NOT NULL,
    Seccion VARCHAR(10) NOT NULL,
    Tutor VARCHAR(75),
    idInstitucion INT NOT NULL,
    FOREIGN KEY (idInstitucion) REFERENCES Institucion(idInstitucion)
);

-- Tabla: Curso (Materias o asignaturas)
CREATE TABLE Curso (
    idCurso INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Curso VARCHAR(45) NOT NULL,
    idGrado INT NOT NULL,
    FOREIGN KEY (idGrado) REFERENCES Grado(idGrado)
);

-- Tabla: Estudiante (Alumnos registrados)
CREATE TABLE Estudiante (
    idEstudiante INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(75) NOT NULL,
    Apellidos VARCHAR(75) NOT NULL,
    DNI VARCHAR(8) NOT NULL UNIQUE,
    Codigo_Est VARCHAR(20) NOT NULL UNIQUE,
    idGrado INT NOT NULL,
    FOREIGN KEY (idGrado) REFERENCES Grado(idGrado)
);

-- Tabla: Profesor_Grado (Relación muchos a muchos entre Personal y Grado)
CREATE TABLE Profesor_Grado (
    idProfesor_Grado INT AUTO_INCREMENT PRIMARY KEY,
    idPersonal INT NOT NULL,
    idGrado INT NOT NULL,
    FOREIGN KEY (idPersonal) REFERENCES Personal(idPersonal),
    FOREIGN KEY (idGrado) REFERENCES Grado(idGrado)
);

-- Tabla: Asistencias (Registro de asistencia de estudiantes)
CREATE TABLE Asistencias (
    idAsistencias INT AUTO_INCREMENT PRIMARY KEY,
    Fecha DATE NOT NULL,
    Inasist_Justificada CHAR(2) DEFAULT 'N',
    Inasist_Injustificada CHAR(2) DEFAULT 'N',
    Tard_Justificada CHAR(2) DEFAULT 'N',
    Tard_Injustificada CHAR(2) DEFAULT 'N',
    idEstudiante INT NOT NULL,
    FOREIGN KEY (idEstudiante) REFERENCES Estudiante(idEstudiante)
);

-- Tabla: Notas_Periodo (Periodos académicos)
CREATE TABLE Notas_Periodo (
    idPeriodo INT AUTO_INCREMENT PRIMARY KEY,
    Periodo VARCHAR(45) NOT NULL
);

-- Tabla: Notas (Registro de calificaciones por estudiante y curso)
CREATE TABLE Notas (
    idNotas INT AUTO_INCREMENT PRIMARY KEY,
    idEstudiante INT NOT NULL,
    idCurso INT NOT NULL,
    idPeriodo INT NOT NULL, -- Relación con Notas_Periodo
    Nota1 DECIMAL(5, 2) DEFAULT NULL,
    Nota2 DECIMAL(5, 2) DEFAULT NULL,
    Nota3 DECIMAL(5, 2) DEFAULT NULL,
    Nota4 DECIMAL(5, 2) DEFAULT NULL,
    Promedio DECIMAL(5, 2) DEFAULT NULL,
    FOREIGN KEY (idEstudiante) REFERENCES Estudiante(idEstudiante),
    FOREIGN KEY (idCurso) REFERENCES Curso(idCurso),
    FOREIGN KEY (idPeriodo) REFERENCES Notas_Periodo(idPeriodo)
);

-- Tabla: Conclusiones_Descriptivas (Comentarios de evaluación)
CREATE TABLE Conclusiones_Descriptivas (
    idConclusion_Descriptiva INT AUTO_INCREMENT PRIMARY KEY,
    idEstudiante INT NOT NULL,
    Descripcion VARCHAR(255) NOT NULL,
    idPeriodo INT NOT NULL, -- Relación con Notas_Periodo
    FOREIGN KEY (idEstudiante) REFERENCES Estudiante(idEstudiante),
    FOREIGN KEY (idPeriodo) REFERENCES Notas_Periodo(idPeriodo)
);

-- Tabla: Notificaciones (Para los padres)
CREATE TABLE Notificaciones (
   idNotificacion INT AUTO_INCREMENT PRIMARY KEY,
   idEstudiante INT NOT NULL,
   Tipo_Notificacion VARCHAR(45) NOT NULL, -- Ejemplo: "Asistencia", "Notas"
   Mensaje TEXT NOT NULL,
   Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (idEstudiante) REFERENCES Estudiante(idEstudiante)
);

-- Tabla: Planificación de clases
CREATE TABLE Planificacion_Clases (
    idPlanificacion INT AUTO_INCREMENT PRIMARY KEY,
    idCurso INT NOT NULL, -- Relación con el curso
    idPersonal INT NOT NULL, -- Relación con el docente
    Fecha DATE NOT NULL, -- Fecha de la planificación
    Objetivo TEXT NOT NULL, -- Objetivo de la clase
    Contenido TEXT NOT NULL, -- Contenidos que se abordarán
    Recursos TEXT, -- Recursos necesarios (opcional)
    Observaciones TEXT, -- Observaciones adicionales (opcional)
    FOREIGN KEY (idCurso) REFERENCES Curso(idCurso),
    FOREIGN KEY (idPersonal) REFERENCES Personal(idPersonal)
);

-- Tabla: Horarios
CREATE TABLE Horarios (
    idHorario INT AUTO_INCREMENT PRIMARY KEY,
    idGrado INT NOT NULL, -- Relación con el grado
    idCurso INT NOT NULL, -- Relación con el curso
    idPersonal INT NOT NULL, -- Relación con el docente
    Dia_Semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado') NOT NULL, -- Día de la semana
    Hora_Inicio TIME NOT NULL, -- Hora de inicio de la clase
    Hora_Fin TIME NOT NULL, -- Hora de fin de la clase
    Aula VARCHAR(10), -- Número o nombre del aula
    FOREIGN KEY (idGrado) REFERENCES Grado(idGrado),
    FOREIGN KEY (idCurso) REFERENCES Curso(idCurso),
    FOREIGN KEY (idPersonal) REFERENCES Personal(idPersonal)
);