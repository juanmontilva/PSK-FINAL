//Crear Base de datos
CREATE DATABASE IF NO EXISTS empresa_db;
USE empresa_db;


//Tabla empresa con borrado logico
CREATE TABLE empresa(
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    rif VARCHAR(20) NOT NULL,
    razon_social VARCHAR(150) NOT NULL,
    direccion TEXT NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) NOT NULL DEFAULT 1
);


//Datos de ejemplo
INSERT INTO empresa (rif, razon_social, direccion, telefono) VALUES
('J-12345678-9', 'Empresa Uno C.A.', 'Calle Falsa 123, Ciudad', '0212-1234567'),
('J-98765432-1', 'Empresa Dos S.A.', 'Avenida Siempre Viva 742, Ciudad', '0212-7654321'),
('J-95353553-1', 'Empresa Tres S.A.', 'Avenida Buenas Viva 743, Ciudad', '0222-7611231');