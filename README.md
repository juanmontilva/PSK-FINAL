Ejercicio Postulacion

# CRUD Empresas - MVC PHP 8+ sin Framework

Sistema CRUD completo con arquitectura **MVC pura** para gestión de empresas.

## Arquitectura MVC

```
PSK-PRO/
├── public/
│   ├── index.php                    ← Front Controller (Router)
│   └── assets/
│       ├── css/style.css            ← Estilos personalizados
│       └── js/app.js                ← Lógica JavaScript/jQuery
├── src/
│   ├── Controllers/
│   │   └── EmpresaController.php    ← Controlador
│   ├── Models/
│   │   └── Empresa.php              ← Modelo (Entidad)
│   ├── Repositories/
│   │   └── EmpresaRepository.php    ← Acceso a datos (PDO)
│   ├── Validators/
│   │   └── EmpresaValidator.php     ← Validaciones
│   ├── Services/
│   │   └── PdfService.php           ← Generación PDF
│   └── Core/
│       ├── Database.php             ← Conexión PDO
│       ├── Router.php               ← Enrutador
│       └── Controller.php           ← Clase base
└── views/
    └── empresas/
        └── index.php                ← Vista (Template HTML)
```

## Requisitos

- PHP 8.0+
- MySQL 5.7+ / MariaDB
- Composer
- XAMPP

## Instalación (≤10 minutos)

### 1. Clonar repositorio

```bash
git clone https://github.com/juanmontilva/PSK-FINAL.git
cd PSK-PRO
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar entorno

```bash
cp .env.example .env
```

Editar `.env`:

```env
# Entorno: development | production
APP_ENV=development
APP_DEBUG=true

# Base de datos
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=empresa_db
DB_USER=root
DB_PASS=
```

### 4. Crear base de datos

Ejecutar en phpMyAdmin:

```sql
CREATE DATABASE empresa_db;
USE empresa_db;

CREATE TABLE empresa (
    id_empresa      INT AUTO_INCREMENT PRIMARY KEY,
    rif             VARCHAR(20) NOT NULL UNIQUE,
    razon_social    VARCHAR(150) NOT NULL,
    direccion       TEXT NOT NULL,
    telefono        VARCHAR(20) NOT NULL,
    fecha_creacion  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activo          TINYINT(1) NOT NULL DEFAULT 1
);
```

### 5. Iniciar servidor

```bash
php -S localhost:8000 -t public
```

### 6. Abrir navegador

```
http://localhost:8000
```

## Endpoints API (RESTful)

| Método | Endpoint                    | Descripción        |
| ------ | --------------------------- | ------------------ |
| GET    | `/api/empresas`             | Listar empresas    |
| GET    | `/api/empresas/{id}`        | Obtener empresa    |
| POST   | `/api/empresas`             | Crear empresa      |
| PUT    | `/api/empresas/{id}`        | Actualizar empresa |
| DELETE | `/api/empresas/{id}`        | Eliminar empresa   |
| GET    | `/api/empresas/export.json` | Exportar JSON      |
| GET    | `/api/empresas/report.pdf`  | Generar PDF        |

## Formato de Error

```json
{ "error": { "code": "BAD_REQUEST", "message": "detalle del error" } }
```

## Validaciones (Servidor)

- **RIF**: Formato `J-12345678-9`, único
- **Razón Social**: Requerido, máx 150 caracteres
- **Dirección**: Requerido
- **Teléfono**: Formato válido

## Búsqueda

Parámetro `?search=`:

- Numérico → busca por `id_empresa`
- Texto → busca por `razon_social` (case-insensitive)

## Entornos

| Variable    | Desarrollo  | Producción |
| ----------- | ----------- | ---------- |
| `APP_ENV`   | development | production |
| `APP_DEBUG` | true        | false      |

## Tecnologías

- PHP 8+ (sin framework, MVC puro)
- MySQL con PDO (sentencias preparadas)
- Composer con PSR-4 autoload
- Bootstrap 5 + jQuery 3.7
- Dompdf para PDF
- vlucas/phpdotenv

## Autor

Juan Carlos Montilva
