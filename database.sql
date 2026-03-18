CREATE DATABASE IF NOT EXISTS catalogo_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE catalogo_hardware;

-- Tabla 1: marcas
CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    pais VARCHAR(100)
) ENGINE=InnoDB;

-- Tabla 2: componentes
CREATE TABLE componentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    marca_id INT NOT NULL,
    FOREIGN KEY (marca_id) REFERENCES marcas(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Insertar 5 registros de prueba en la tabla marcas
INSERT INTO marcas (nombre, pais) VALUES
('Asus', 'Taiwán'),
('Corsair', 'Estados Unidos'),
('MSI', 'Taiwán'),
('Logitech', 'Suiza'),
('Nvidia', 'Estados Unidos');

-- Insertar 5 registros de prueba en la tabla componentes
INSERT INTO componentes (nombre, descripcion, precio, stock, marca_id) VALUES
('Placa Base ROG Strix B550-F', 'Placa base ATX para procesadores AMD AM4', 189.99, 15, 1),
('Memoria RAM Vengeance LPX 32GB', '2x16GB DDR4 3200MHz', 79.99, 50, 2),
('Tarjeta Gráfica RTX 4060 Ti', '8GB GDDR6', 399.00, 10, 3),
('Ratón G Pro X Superlight', 'Ratón inalámbrico ultraligero', 129.50, 20, 4),
('Tarjeta Gráfica RTX 4070 SUPER', '12GB GDDR6X', 659.90, 5, 5);
