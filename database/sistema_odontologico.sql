-- Sistema Odontológico - PostgreSQL
-- Base de datos: odontologica

-- Tipos ENUM (equivalente a los ENUM de MySQL)
CREATE TYPE sexo_enum AS ENUM ('M', 'F', 'Otro');
CREATE TYPE tipo_movimiento_enum AS ENUM ('debito', 'credito');
CREATE TYPE categoria_movimiento_enum AS ENUM ('cobro', 'descuento', 'reembolso', 'otros');
CREATE TYPE tipo_usuario_enum AS ENUM ('admin', 'dentista', 'empleado');

-- --------------------------------------------------------
-- Tabla especialidades (sin claves foráneas)
-- --------------------------------------------------------
CREATE TABLE especialidades (
  id_especialidad SERIAL PRIMARY KEY,
  descripcion VARCHAR(100) NOT NULL
);

-- --------------------------------------------------------
-- Tabla pacientes (sin claves foráneas)
-- --------------------------------------------------------
CREATE TABLE pacientes (
  id_paciente SERIAL PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  direccion VARCHAR(255) DEFAULT NULL,
  telefono VARCHAR(20) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  cep VARCHAR(10) DEFAULT NULL,
  cpf VARCHAR(24) DEFAULT NULL,
  rg VARCHAR(20) DEFAULT NULL,
  sexo sexo_enum DEFAULT NULL,
  fecha_nacimiento DATE DEFAULT NULL,
  ciudad VARCHAR(100) DEFAULT NULL,
  estado VARCHAR(2) DEFAULT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- Tabla dentistas
-- --------------------------------------------------------
CREATE TABLE dentistas (
  id_dentista SERIAL PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  especialidad_id INTEGER DEFAULT NULL REFERENCES especialidades(id_especialidad),
  telefono VARCHAR(20) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  direccion VARCHAR(255) DEFAULT NULL,
  ciudad VARCHAR(100) DEFAULT NULL,
  estado VARCHAR(2) DEFAULT NULL,
  cep VARCHAR(10) DEFAULT NULL,
  rg VARCHAR(20) DEFAULT NULL,
  cpf VARCHAR(14) DEFAULT NULL,
  cro VARCHAR(20) DEFAULT NULL
);

-- --------------------------------------------------------
-- Tabla empleados
-- --------------------------------------------------------
CREATE TABLE empleados (
  id_empleado SERIAL PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  puesto VARCHAR(50) DEFAULT NULL,
  telefono VARCHAR(20) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  direccion VARCHAR(255) DEFAULT NULL,
  cep VARCHAR(10) DEFAULT NULL,
  cpf VARCHAR(14) DEFAULT NULL,
  rg VARCHAR(20) DEFAULT NULL,
  sexo sexo_enum DEFAULT NULL,
  ciudad VARCHAR(100) DEFAULT NULL,
  estado VARCHAR(2) DEFAULT NULL
);

-- --------------------------------------------------------
-- Tabla usuarios
-- --------------------------------------------------------
CREATE TABLE usuarios (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  clave VARCHAR(255) NOT NULL,
  tipo tipo_usuario_enum NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- Tabla citas
-- --------------------------------------------------------
CREATE TABLE citas (
  id_cita SERIAL PRIMARY KEY,
  paciente_id INTEGER DEFAULT NULL REFERENCES pacientes(id_paciente),
  dentista_id INTEGER DEFAULT NULL REFERENCES dentistas(id_dentista),
  fecha_hora TIMESTAMP DEFAULT NULL,
  descripcion TEXT DEFAULT NULL
);

-- --------------------------------------------------------
-- Tabla anamnesis
-- --------------------------------------------------------
CREATE TABLE anamnesis (
  id_anamnesis SERIAL PRIMARY KEY,
  paciente_id INTEGER DEFAULT NULL REFERENCES pacientes(id_paciente),
  dentista_id INTEGER DEFAULT NULL REFERENCES dentistas(id_dentista),
  descripcion TEXT DEFAULT NULL,
  fecha DATE DEFAULT NULL
);

-- --------------------------------------------------------
-- Tabla presupuestos
-- --------------------------------------------------------
CREATE TABLE presupuestos (
  id_presupuesto SERIAL PRIMARY KEY,
  anamnesis_id INTEGER DEFAULT NULL REFERENCES anamnesis(id_anamnesis) ON DELETE CASCADE ON UPDATE CASCADE,
  paciente_id INTEGER DEFAULT NULL REFERENCES pacientes(id_paciente) ON DELETE SET NULL ON UPDATE CASCADE,
  dentista_id INTEGER DEFAULT NULL REFERENCES dentistas(id_dentista) ON DELETE SET NULL ON UPDATE CASCADE,
  descripcion_servicio TEXT DEFAULT NULL,
  valor DECIMAL(10,2) DEFAULT NULL,
  fecha DATE DEFAULT NULL
);

-- --------------------------------------------------------
-- Tabla recetas
-- --------------------------------------------------------
CREATE TABLE recetas (
  id_receta SERIAL PRIMARY KEY,
  paciente_id INTEGER DEFAULT NULL REFERENCES pacientes(id_paciente),
  dentista_id INTEGER DEFAULT NULL REFERENCES dentistas(id_dentista),
  fecha DATE DEFAULT NULL,
  contenido TEXT DEFAULT NULL
);

-- --------------------------------------------------------
-- Tabla movimientos_contables
-- --------------------------------------------------------
CREATE TABLE movimientos_contables (
  id_movimiento SERIAL PRIMARY KEY,
  paciente_id INTEGER NOT NULL REFERENCES pacientes(id_paciente) ON DELETE CASCADE ON UPDATE CASCADE,
  presupuesto_id INTEGER DEFAULT NULL REFERENCES presupuestos(id_presupuesto) ON DELETE SET NULL ON UPDATE CASCADE,
  fecha_movimiento DATE NOT NULL,
  descripcion TEXT DEFAULT NULL,
  tipo tipo_movimiento_enum NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  categoria categoria_movimiento_enum DEFAULT 'cobro',
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- Tabla firmas
-- --------------------------------------------------------
CREATE TABLE firmas (
  id SERIAL PRIMARY KEY,
  token VARCHAR(64) DEFAULT NULL UNIQUE,
  tipo_informe VARCHAR(50) DEFAULT NULL,
  datos_informe TEXT DEFAULT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices para mejorar el rendimiento (claves foráneas)
CREATE INDEX idx_citas_paciente_id ON citas(paciente_id);
CREATE INDEX idx_citas_dentista_id ON citas(dentista_id);
CREATE INDEX idx_anamnesis_paciente_id ON anamnesis(paciente_id);
CREATE INDEX idx_anamnesis_dentista_id ON anamnesis(dentista_id);
CREATE INDEX idx_dentistas_especialidad_id ON dentistas(especialidad_id);
CREATE INDEX idx_movimientos_contables_paciente_id ON movimientos_contables(paciente_id);
CREATE INDEX idx_movimientos_contables_presupuesto_id ON movimientos_contables(presupuesto_id);
CREATE INDEX idx_presupuestos_paciente_id ON presupuestos(paciente_id);
CREATE INDEX idx_presupuestos_dentista_id ON presupuestos(dentista_id);
CREATE INDEX idx_presupuestos_anamnesis_id ON presupuestos(anamnesis_id);
CREATE INDEX idx_recetas_paciente_id ON recetas(paciente_id);
CREATE INDEX idx_recetas_dentista_id ON recetas(dentista_id);

-- Datos iniciales: usuario administrador
INSERT INTO usuarios (nombre, email, clave, tipo, creado_en, actualizado_en) VALUES
('Admin', 'admin@admin.com', '$2y$10$98OeeVRlL06jSI/nxvL12OHJG0i8gIiqxDSJIGmVigRj5ICN5rL.K', 'admin', '2025-04-13 09:33:22', '2025-04-13 09:33:22');
