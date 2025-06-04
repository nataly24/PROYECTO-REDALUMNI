DROP DATABASE pruebas;
CREATE DATABASE pruebas;
USE pruebas;

-- 1. Roles
CREATE TABLE rol (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre_rol ENUM('Administrador', 'Colaborador', 'Exalumno', 'Empresa') UNIQUE NOT NULL,
  descripcion VARCHAR(255)
);

-- 2. Permisos
CREATE TABLE permiso (
  id_permiso INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  descripcion VARCHAR(255),
  codigo VARCHAR(50) NOT NULL UNIQUE
);

-- 3. Relación Rol-Permiso
CREATE TABLE rol_permiso (
  id_rol INT NOT NULL,
  id_permiso INT NOT NULL,
  PRIMARY KEY (id_rol, id_permiso),
  FOREIGN KEY (id_rol) REFERENCES rol(id_rol),
  FOREIGN KEY (id_permiso) REFERENCES permiso(id_permiso)
);

-- 4. Usuarios
CREATE TABLE usuario (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  correo_electronico VARCHAR(255) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  estado_cuenta ENUM('pendiente', 'activo', 'rechazado') DEFAULT 'pendiente',
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 5. Relación Usuario-Rol
CREATE TABLE rol_usuario (
  id_rol_usuario INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_rol INT NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
  FOREIGN KEY (id_rol) REFERENCES rol(id_rol),
  UNIQUE (id_usuario, id_rol)
);

-- 6. Persona (datos básicos)
CREATE TABLE persona (
  id_persona INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  primer_nombre VARCHAR(100) NOT NULL,
  segundo_nombre VARCHAR(100),
  primer_apellido VARCHAR(100) NOT NULL,
  segundo_apellido VARCHAR(100),
  genero ENUM('Masculino', 'Femenino', 'Otro'),
  fecha_nacimiento DATE,
  direccion_domicilio VARCHAR(255),
  celular_contacto VARCHAR(20),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- 7. Exalumno
CREATE TABLE exalumno (
  id_exalumno INT AUTO_INCREMENT PRIMARY KEY,
  id_persona INT NOT NULL,
  ci VARCHAR(20) UNIQUE NOT NULL,
  codigo_carrera VARCHAR(20) NOT NULL,
  carrera VARCHAR(100) NOT NULL,
  facultad VARCHAR(100) NOT NULL,
  estado_academico ENUM('Egresado', 'Titulado') DEFAULT 'Egresado',
  fecha_colacion DATE,
  ciudad_residencia VARCHAR(100),
  telefono_contacto VARCHAR(20),
  linkedin VARCHAR(255),
  perfil_profesional TEXT,
  FOREIGN KEY (id_persona) REFERENCES persona(id_persona) ON DELETE CASCADE
);

-- 8. Auditoría de cambio de estado académico
CREATE TABLE auditoria_estado_academico (
  id_auditoria INT AUTO_INCREMENT PRIMARY KEY,
  id_exalumno INT NOT NULL,
  estado_anterior ENUM('Egresado', 'Titulado'),
  estado_nuevo ENUM('Egresado', 'Titulado'),
  fecha_cambio DATETIME DEFAULT CURRENT_TIMESTAMP,
  cambiado_por INT NOT NULL,
  observaciones TEXT,
  FOREIGN KEY (id_exalumno) REFERENCES exalumno(id_exalumno),
  FOREIGN KEY (cambiado_por) REFERENCES usuario(id_usuario)
);

-- 9. Formación académica
CREATE TABLE formacion_academica (
  id_formacion INT AUTO_INCREMENT PRIMARY KEY,
  id_exalumno INT NOT NULL,
  tipo ENUM('Bachillerato', 'Pregrado', 'Posgrado', 'Curso') NOT NULL,
  titulo_obtenido VARCHAR(255),
  institucion VARCHAR(255),
  fecha_inicio DATE,
  fecha_fin DATE,
  FOREIGN KEY (id_exalumno) REFERENCES exalumno(id_exalumno) ON DELETE CASCADE
);

-- 10. Experiencia laboral
CREATE TABLE experiencia_laboral (
  id_experiencia INT AUTO_INCREMENT PRIMARY KEY,
  id_exalumno INT NOT NULL,
  puesto VARCHAR(100),
  empresa VARCHAR(100),
  fecha_inicio DATE,
  fecha_fin DATE,
  descripcion TEXT,
  FOREIGN KEY (id_exalumno) REFERENCES exalumno(id_exalumno) ON DELETE CASCADE
);

-- 11. Referencias laborales
CREATE TABLE referencia_laboral (
  id_referencia INT AUTO_INCREMENT PRIMARY KEY,
  id_experiencia INT NOT NULL,
  nombre_contacto VARCHAR(100),
  cargo_contacto VARCHAR(100),
  telefono_contacto VARCHAR(50),
  correo_contacto VARCHAR(100),
  relacion_laboral TEXT,
  FOREIGN KEY (id_experiencia) REFERENCES experiencia_laboral(id_experiencia) ON DELETE CASCADE
);

-- 12. Habilidades
CREATE TABLE habilidades (
  id_habilidad INT AUTO_INCREMENT PRIMARY KEY,
  id_exalumno INT NOT NULL,
  nombre VARCHAR(100),
  tipo ENUM('Técnica', 'Blanda', 'Idioma'),
  nivel ENUM('Básico', 'Intermedio', 'Avanzado'),
  FOREIGN KEY (id_exalumno) REFERENCES exalumno(id_exalumno) ON DELETE CASCADE
);

-- 13. Competencias
CREATE TABLE competencias (
  id_competencia INT AUTO_INCREMENT PRIMARY KEY,
  id_exalumno INT NOT NULL,
  herramienta VARCHAR(100) NOT NULL,
  nivel ENUM('Básico', 'Intermedio', 'Avanzado') NOT NULL,
  FOREIGN KEY (id_exalumno) REFERENCES exalumno(id_exalumno) ON DELETE CASCADE
);

-- 14. Empresa
CREATE TABLE empresa (
  id_empresa INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  nombre_empresa VARCHAR(255) NOT NULL,
  nit VARCHAR(20) NOT NULL UNIQUE,
  correo_empresa VARCHAR(255) NOT NULL UNIQUE,
  tipo_empresa VARCHAR(100),
  telefono VARCHAR(20),
  direccion_empresa TEXT,
  descripcion_empresa TEXT,
  estado_empresa ENUM('activa', 'inactiva', 'pendiente') DEFAULT 'pendiente',
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- 15. Oferta laboral
CREATE TABLE oferta_laboral (
  id_oferta INT AUTO_INCREMENT PRIMARY KEY,
  id_empresa INT NOT NULL,
  titulo_puesto VARCHAR(255) NOT NULL,
  descripcion_puesto TEXT NOT NULL,
  departamento VARCHAR(100),
  fecha_publicacion DATE DEFAULT CURRENT_DATE,
  fecha_vencimiento DATE NOT NULL,
  modalidad ENUM('Presencial', 'Remoto', 'Híbrido'),
  tipo_contrato ENUM('Eventual', 'Temporal', 'Permanente'),
  funcion_principal TEXT,
  requisitos TEXT,
  competencias TEXT,
  valorable TEXT,
  publicada_por INT NOT NULL,
  nombre_contacto_rrhh VARCHAR(100),
  cargo_contacto_rrhh VARCHAR(100),
  celular_contacto_rrhh VARCHAR(30),
  correo_contacto_rrhh VARCHAR(150),
  FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa),
  FOREIGN KEY (publicada_por) REFERENCES usuario(id_usuario)
);

-- 16. Postulación a ofertas
CREATE TABLE postulacion_oferta (
  id_postulacion INT AUTO_INCREMENT PRIMARY KEY,
  id_exalumno INT NOT NULL,
  id_oferta INT NOT NULL,
  fecha_postulacion DATETIME DEFAULT CURRENT_TIMESTAMP,
  estado ENUM('Enviada', 'Revisada', 'Aceptado', 'Rechazado') DEFAULT 'Enviada',
  observaciones TEXT,
  FOREIGN KEY (id_exalumno) REFERENCES exalumno(id_exalumno),
  FOREIGN KEY (id_oferta) REFERENCES oferta_laboral(id_oferta),
  UNIQUE (id_exalumno, id_oferta)
);

-- 17. Redes sociales
CREATE TABLE redes_sociales (
  id_red INT AUTO_INCREMENT PRIMARY KEY,
  entidad_tipo ENUM('Exalumno', 'Empresa') NOT NULL,
  entidad_id INT NOT NULL,
  red_social VARCHAR(100) NOT NULL,
  url VARCHAR(255) NOT NULL,
  UNIQUE (entidad_tipo, entidad_id, red_social)
);


-- 18. Páginas web
CREATE TABLE paginas_web (
  id_pagina INT AUTO_INCREMENT PRIMARY KEY,
  entidad_tipo ENUM('Exalumno', 'Empresa') NOT NULL,
  entidad_id INT NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  url VARCHAR(255) NOT NULL,
  UNIQUE (entidad_tipo, entidad_id, url)
);

-- 19. Subenil
CREATE TABLE subenil (
  id_item INT AUTO_INCREMENT PRIMARY KEY,
  nombre_item VARCHAR(100) NOT NULL,
  categoria ENUM('Material de Colación', 'Material de Oficina', 'Otro') NOT NULL,
  tipo_item VARCHAR(100),
  cantidad_disponible INT NOT NULL DEFAULT 0,
  unidad VARCHAR(20) DEFAULT 'unidad',
  observaciones TEXT,
  registrado_por INT NOT NULL,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (registrado_por) REFERENCES usuario(id_usuario)
);

CREATE TABLE ingreso_subenil (
  id_ingreso INT AUTO_INCREMENT PRIMARY KEY,
  id_item INT NOT NULL,
  cantidad INT NOT NULL,
  motivo VARCHAR(100),
  fecha_ingreso DATETIME DEFAULT CURRENT_TIMESTAMP,
  ingresado_por INT NOT NULL,
  observaciones TEXT,
  FOREIGN KEY (id_item) REFERENCES subenil(id_item),
  FOREIGN KEY (ingresado_por) REFERENCES usuario(id_usuario)
);

CREATE TABLE salida_subenil (
  id_salida INT AUTO_INCREMENT PRIMARY KEY,
  id_item INT NOT NULL,
  cantidad INT NOT NULL,
  destino_colacion VARCHAR(100),
  fecha_salida DATETIME DEFAULT CURRENT_TIMESTAMP,
  entregado_por INT NOT NULL,
  recibido_por VARCHAR(100),
  observaciones TEXT,
  FOREIGN KEY (id_item) REFERENCES subenil(id_item),
  FOREIGN KEY (entregado_por) REFERENCES usuario(id_usuario)
);

-- 20. Convenios
CREATE TABLE convenio (
  id_convenio INT AUTO_INCREMENT PRIMARY KEY,
  id_empresa INT NOT NULL,
  tipo_convenio VARCHAR(100) NOT NULL,
  numero_convenio VARCHAR(50) NOT NULL UNIQUE,
  identificador_convenio VARCHAR(50) UNIQUE,
  fecha_inicio DATE,
  fecha_fin DATE,
  estado_vigencia ENUM('vigente', 'vencido', 'prorrogado'),
  observaciones TEXT,
  FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa)
);

-- 21. Cartas
CREATE TABLE carta (
  id_carta INT AUTO_INCREMENT PRIMARY KEY,
  tipo_carta ENUM('Recibida', 'Enviada') NOT NULL,
  numero_carta VARCHAR(50) UNIQUE,
  asunto VARCHAR(255),
  remitente_destinatario VARCHAR(255),
  fecha DATE,
  observaciones TEXT,
  archivo_url VARCHAR(255),
  registrado_por INT NOT NULL,
  FOREIGN KEY (registrado_por) REFERENCES usuario(id_usuario)
);

-- 22. Historial de acciones
CREATE TABLE historial_acciones (
  id_historial INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  accion VARCHAR(100) NOT NULL,
  descripcion TEXT,
  fecha_accion DATETIME DEFAULT CURRENT_TIMESTAMP,
  ip_address VARCHAR(45),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);
