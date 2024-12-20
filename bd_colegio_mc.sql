-- Crear la base de datos "bd_colegio_mc"
CREATE DATABASE IF NOT EXISTS bd_colegio_mc;
USE bd_colegio_mc;

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

-- Poblar la tabla Tipo_Usuario
INSERT INTO Tipo_Usuario (Tipo) VALUES
('Administrador'),
('Docente'),
('Padre'),
('Usuario'),
('Secretario'),
('Director'),
('Asistente'),
('Coordinador'),
('Tutor'),
('Supervisor');

-- Poblar la tabla Personal
INSERT INTO Personal (Nombre, Apellidos, Usuario, Clave, Correo, idTipo_Usuario, idInstitucion) VALUES
('Juan', 'Perez Gomez', 'jperez', 'clave123', 'jperez@gmail.com', 2, 1),
('María', 'Lopez Alvarez', 'mlopez', 'clave123', 'mlopez@gmail.com', 2, 1),
('Carlos', 'Sanchez Ruiz', 'csanchez', 'clave123', 'csanchez@gmail.com', 1, 1),
('Ana', 'Torres Flores', 'atorres', 'clave123', 'atorres@gmail.com', 2, 1),
('Luis', 'Martinez Castro', 'lmartinez', 'clave123', 'lmartinez@gmail.com', 2, 1),
('Sofia', 'Diaz Morales', 'sdiaz', 'clave123', 'sdiaz@gmail.com', 3, 1),
('Pedro', 'Ramirez Rojas', 'pramirez', 'clave123', 'pramirez@gmail.com', 2, 1),
('Isabel', 'Vargas Soto', 'ivargas', 'clave123', 'ivargas@gmail.com', 4, 1),
('Jose', 'Navarro Peña', 'jnavarro', 'clave123', 'jnavarro@gmail.com', 3, 1),
('Paula', 'Garcia Luna', 'pgarcia', 'clave123', 'pgarcia@gmail.com', 4, 1);

-- Poblar la tabla Grado
INSERT INTO Grado (Nombre_Grado, Seccion, Tutor, idInstitucion) VALUES
('Primero', 'A', 'Juan Perez', 1),
('Primero', 'B', 'Maria Lopez', 1),
('Segundo', 'A', 'Carlos Sanchez', 1),
('Segundo', 'B', 'Ana Torres', 1),
('Tercero', 'A', 'Luis Martinez', 1),
('Tercero', 'B', 'Sofia Diaz', 1),
('Cuarto', 'A', 'Pedro Ramirez', 1),
('Cuarto', 'B', 'Isabel Vargas', 1),
('Quinto', 'A', 'Jose Navarro', 1),
('Quinto', 'B', 'Paula Garcia', 1);

-- Poblar la tabla Curso
INSERT INTO Curso (Nombre_Curso, idGrado) VALUES
('Matemática', 1),
('Comunicación', 1),
('Ciencias', 2),
('Historia', 2),
('Inglés', 3),
('Arte', 3),
('Educación Física', 4),
('Computación', 4),
('Filosofía', 5),
('Química', 5);

-- Poblar la tabla Estudiante
INSERT INTO Estudiante (Nombre, Apellidos, DNI, Codigo_Est, idGrado) VALUES
('Lucia', 'Hernandez Rios', '12345678', 'E001', 1),
('Miguel', 'Castro Salas', '23456789', 'E002', 1),
('Andrea', 'Fernandez Vega', '34567890', 'E003', 2),
('David', 'Ortiz Flores', '45678901', 'E004', 2),
('Santiago', 'Perez Gomez', '56789012', 'E005', 3),
('Elena', 'Ramirez Lopez', '67890123', 'E006', 3),
('Natalia', 'Ruiz Torres', '78901234', 'E007', 4),
('Gabriel', 'Morales Sanchez', '89012345', 'E008', 4),
('Carlos', 'Diaz Vargas', '90123456', 'E009', 5),
('Valeria', 'Vargas Navarro', '01234567', 'E010', 5);

-- Poblar la tabla Profesor_Grado
INSERT INTO Profesor_Grado (idPersonal, idGrado) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

-- Poblar la tabla Asistencias
INSERT INTO Asistencias (Fecha, Inasist_Justificada, Inasist_Injustificada, Tard_Justificada, Tard_Injustificada, idEstudiante) VALUES
('2024-12-01', 'N', 'Y', 'N', 'N', 1),
('2024-12-01', 'Y', 'N', 'N', 'N', 2),
('2024-12-02', 'N', 'N', 'Y', 'N', 3),
('2024-12-02', 'N', 'N', 'N', 'Y', 4),
('2024-12-03', 'N', 'Y', 'N', 'N', 5),
('2024-12-03', 'N', 'N', 'N', 'Y', 6),
('2024-12-04', 'Y', 'N', 'N', 'N', 7),
('2024-12-04', 'N', 'Y', 'N', 'N', 8),
('2024-12-05', 'N', 'N', 'Y', 'N', 9),
('2024-12-05', 'N', 'N', 'N', 'Y', 10);

-- Poblar la tabla Notas_Periodo
INSERT INTO Notas_Periodo (Periodo) VALUES
('Primer Trimestre'),
('Segundo Trimestre'),
('Tercer Trimestre'),
('Cuarto Trimestre'),
('Primer Semestre'),
('Segundo Semestre'),
('Anual'),
('Examen Extraordinario'),
('Refuerzo Académico'),
('Evaluación Final');

-- Poblar la tabla Notas
INSERT INTO Notas (idEstudiante, idCurso, idPeriodo, Nota1, Nota2, Nota3, Nota4, Promedio) VALUES
(1, 1, 1, 14.5, 16.0, 15.0, 14.0, 14.88),
(2, 2, 1, 12.0, 13.0, 14.0, 15.0, 13.50),
(3, 3, 1, 17.0, 18.0, 19.0, 20.0, 18.50),
(4, 4, 2, 10.0, 11.0, 12.0, 13.0, 11.50),
(5, 5, 2, 15.0, 16.0, 14.0, 15.0, 15.00),
(6, 6, 2, 18.0, 19.0, 17.0, 20.0, 18.50),
(7, 7, 3, 13.0, 14.0, 12.0, 15.0, 13.50),
(8, 8, 3, 16.0, 17.0, 16.0, 15.0, 16.00),
(9, 9, 3, 14.0, 13.0, 15.0, 16.0, 14.50),
(10, 10, 1, 19.0, 20.0, 18.0, 20.0, 19.25);

-- Poblar la tabla Conclusiones_Descriptivas
INSERT INTO Conclusiones_Descriptivas (idEstudiante, Descripcion, idPeriodo) VALUES
(1, 'Excelente rendimiento académico.', 1),
(2, 'Buen desempeño en las actividades grupales.', 1),
(3, 'Debe mejorar la puntualidad.', 2),
(4, 'Participación activa en clases.', 2),
(5, 'Sobresale en las asignaturas de ciencias.', 2),
(6, 'Dificultades en matemáticas, necesita refuerzo.', 3),
(7, 'Buena actitud y disposición para aprender.', 3),
(8, 'Excelente en trabajo colaborativo.', 3),
(9, 'Destaca en las actividades creativas.', 1),
(10, 'Buen manejo de las herramientas tecnológicas.', 1);

-- Poblar la tabla Notificaciones
INSERT INTO Notificaciones (idEstudiante, Tipo_Notificacion, Mensaje) VALUES
(1, 'Asistencia', 'Ausencia no justificada.'),
(2, 'Nota', 'Bajo promedio en matemáticas.'),
(3, 'Nota', 'Excelente desempeño en ciencias.'),
(4, 'Asistencia', 'Tardanza reiterada.'),
(5, 'General', 'Se acerca el periodo de exámenes.'),
(6, 'Nota', 'Necesita refuerzo en historia.'),
(7, 'Asistencia', 'Tardanza no justificada.'),
(8, 'Nota', 'Excelente promedio en filosofía.'),
(9, 'General', 'Reunión de padres programada para el lunes.'),
(10, 'Asistencia', 'Ausencia injustificada en la última semana.');

-- Poblar la tabla Institución
INSERT INTO Institucion (Nombre, Nivel, Codigo_Modular) 
VALUES ('Idat', 'Nivel Educativo', 'C123456');

-- Poblar la tabla Horarios
INSERT INTO Horarios (idGrado, idCurso, idPersonal, Dia_Semana, Hora_Inicio, Hora_Fin, Aula) 
VALUES 
(1, 1, 1, 'Lunes', '08:00:00', '09:00:00', 'A101'),
(1, 2, 2, 'Martes', '10:00:00', '11:00:00', 'B202');
