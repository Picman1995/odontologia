-- Quitar columna estado (departamento/UF) de pacientes, dentistas y empleados.
ALTER TABLE pacientes DROP COLUMN IF EXISTS estado;
ALTER TABLE dentistas DROP COLUMN IF EXISTS estado;
ALTER TABLE empleados DROP COLUMN IF EXISTS estado;
