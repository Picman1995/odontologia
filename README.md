# Sistema de consultorio odontológico

Sistema web desarrollado en PHP 8.2, PostgreSQL y PDO, con interfaz moderna y responsiva usando Bootstrap 5.3.3. Orientado a la gestión completa de clínicas odontológicas.

## Funcionalidades

### Autenticación y control de acceso
- Login con verificación segura de contraseña (hash).
- Sesión protegida por tipo de usuario (`admin`, `dentista`, `empleado`).
- Control de autorización por tipo.
- Cambio de contraseña con verificación de la contraseña actual.

### Gestión de usuarios
- Alta de nuevos usuarios (admin, dentista y empleado).
- Edición, listado y eliminación de cuentas.
- Acceso restringido al área de gestión para administradores.

### Gestión de profesionales
- **Dentistas**: nombre, especialidad, teléfono, correo y dirección.
- **Empleados**: cargos como recepcionista, técnico en salud bucal, etc.; teléfono, CPF, RG, dirección y sexo.

### Gestión de pacientes
- Alta completa de pacientes.
- Listado con búsqueda, edición y eliminación.
- Ficha individual del paciente.

### Anamnesis
- Registro del historial clínico del paciente.
- Informe con firma digital (código QR).
- Exportación a PDF.

### Presupuestos
- Creación de presupuestos vinculados a la anamnesis.
- Generación automática del identificador a partir del paciente.
- Exportación del presupuesto en PDF.

### Citas
- Registro de consultas con fecha, hora, dentista y paciente.
- Pantalla de listado responsiva.
- Visualización en formato calendario.

### Movimientos contables
- Registro de créditos y débitos asociados a presupuestos.
- Control de pagos y saldo por paciente.
- Generación de extracto financiero en PDF.

### Informes
- Informe PDF de extractos y presupuestos.
- Información organizada por paciente.
- Estilo adecuado para impresión.

### Datos de la clínica
- Nombre, dirección, ciudad, estado y CEP de la clínica.
- Visualización con iconos y diseño informativo.

## Tecnologías utilizadas
- PHP 8.2+
- PostgreSQL
- PDO (PHP Data Objects)
- Bootstrap 5.3.3
- DomPDF (generación de PDF)
- Endroid QR Code (código QR para firma)
- Apache + PHP + PostgreSQL (entorno de desarrollo)

## Estructura de directorios
```
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── config/
├── database/
├── public/
├── routes/
└── vendor/
```

## Cómo ejecutar
1. Clona el repositorio o copia los archivos del proyecto.
2. Configura el archivo `config/config.php`: base de datos, `BASE_URL` y `BASE_PATH` (ver más abajo).
3. Instala las dependencias con Composer:
   ```bash
   composer install
   ```
4. Crea la base de datos en PostgreSQL (por ejemplo `odontologica`).
5. Ejecuta el script SQL de la carpeta `database/` (`sistema_odontologico.sql`) en esa base de datos.
6. Inicia el servidor y accede a la aplicación.

### Opción A: Servidor embebido de PHP (recomendado para desarrollo)
Desde la carpeta **public** del proyecto:
```bash
cd public
php -S localhost:8000
```
En `config/config.php` debe quedar:
- `BASE_URL` = `'http://localhost:8000'`
- `BASE_PATH` = `''`

Entonces la aplicación se abre en **http://localhost:8000** (por ejemplo http://localhost:8000/login). No uses `/odontologia/public` en la URL porque la raíz del servidor ya es `public/`.

### Opción B: Apache / XAMPP
Si usas Apache con el proyecto en una subcarpeta (por ejemplo `http://localhost/odontologia/public`), en `config/config.php`:
- `BASE_URL` = `'http://localhost/odontologia/public'`
- `BASE_PATH` = `'/odontologia/public'`

## Acceso al sistema
- **Servidor embebido:** http://localhost:8000  
- **Apache:** según tu instalación (ej.: http://localhost/odontologia/public)
- Email: admin@admin.com
- Contraseña: 123456

---

Desarrollado para facilitar la gestión de clínicas odontológicas.
