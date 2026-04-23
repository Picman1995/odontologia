-- Dentistas: quitar campos de identificación Brasil (CEP, RG, CPF) y renombrar CRO a matrícula profesional (Paraguay).
ALTER TABLE dentistas DROP COLUMN IF EXISTS cep;
ALTER TABLE dentistas DROP COLUMN IF EXISTS rg;
ALTER TABLE dentistas DROP COLUMN IF EXISTS cpf;
ALTER TABLE dentistas RENAME COLUMN cro TO matricula_profesional;
ALTER TABLE dentistas ALTER COLUMN matricula_profesional TYPE VARCHAR(40);
