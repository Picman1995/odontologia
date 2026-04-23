-- Empleados: quitar campos Brasil (CEP, CPF, RG) para alinear con Paraguay.
ALTER TABLE empleados DROP COLUMN IF EXISTS cep;
ALTER TABLE empleados DROP COLUMN IF EXISTS cpf;
ALTER TABLE empleados DROP COLUMN IF EXISTS rg;
