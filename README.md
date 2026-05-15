# Hardware Hub Professional 🛡️

[![Version](https://img.shields.io/badge/version-1.2.0-blue.svg)](https://github.com/juanjoacevedoma/ProyectoAPLWEB-Juanjo)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Dashboard profesional de alto rendimiento para la gestión centralizada de inventario y mantenimiento de hardware. Diseñado bajo estándares de ingeniería para entornos corporativos de alta demanda.

---

## 🚀 Visión General

**Hardware Hub Pro** es una solución integral orientada a departamentos de IT para el control exhaustivo de activos tecnológicos. La plataforma no solo gestiona el stock, sino que proporciona un historial crítico de mantenimientos, métricas en tiempo real y una interfaz optimizada para la eficiencia operativa.

### 💎 Características de Élite
- **🎛️ Dashboard de Control**: Visualización instantánea del estado de los equipos y niveles de stock.
- **🔐 Seguridad de Grado Industrial**: Sistema de autenticación con hashing bcrypt y gestión de sesiones segura.
- **🛠️ Gestión Multicapa**: CRUD avanzado para componentes, marcas y registros de mantenimiento relacionados.
- **📊 Analítica Integrada**: Reportes técnicos y gráficas dinámicas sobre la distribución de hardware.
- **📱 Interfaz Adaptive**: Diseño **Glassmorphism 3.0** totalmente responsive y optimizado para múltiples dispositivos.
- **📜 Trazabilidad**: Registro de auditoría para cada intervención técnica realizada.

---

## 🛠️ Stack Tecnológico

La arquitectura ha sido diseñada priorizando la seguridad, la velocidad y la escalabilidad.

| Capa | Tecnologías |
| :--- | :--- |
| **Backend** | ![PHP](https://img.shields.io/badge/PHP-8.2-777BB4) ![PDO](https://img.shields.io/badge/Database-PDO-orange) |
| **Frontend** | ![HTML5](https://img.shields.io/badge/HTML5-E34F26) ![CSS3](https://img.shields.io/badge/CSS3-1572B6) ![JS](https://img.shields.io/badge/JS-ES6+-F7DF1E) |
| **Base de Datos** | ![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1) ![MariaDB](https://img.shields.io/badge/MariaDB-003545) |
| **DevOps** | ![Git](https://img.shields.io/badge/Git-F05032) ![XAMPP](https://img.shields.io/badge/Dev-XAMPP-FB7A24) |

---

## ⚙️ Configuración del Entorno

Sigue estos pasos para desplegar una instancia local del sistema:

### 1. Preparación de la Base de Datos 📦
1. Inicia tu servidor MySQL (vía XAMPP, Docker o nativo).
2. Crea un esquema denominado `catalogo_hardware`:
   ```sql
   CREATE DATABASE catalogo_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Importa el archivo estructural primario:
   - Utiliza la terminal o phpMyAdmin para importar `database.sql`.
   - Este archivo autogenera las tablas `componentes`, `marcas`, `mantenimientos` y `usuarios`.

### 2. Sincronización del Aplicativo 📂
1. Clona el repositorio en el directorio raíz de tu servidor (`htdocs` o `www`):
   ```bash
   git clone https://github.com/juanjoacevedoma/ProyectoAPLWEB-Juanjo.git
   ```
2. Configura las variables de entorno:
   - Localiza el archivo `config.example.php`.
   - Renómbralo a `config.php`.
   - Ajusta los parámetros de conexión:
     ```php
     $host = "localhost";
     $dbname = "catalogo_hardware";
     $user = "tu_usuario";
     $pass = "tu_password";
     ```

---

## 🔐 Modelos de Acceso

El sistema implementa un Control de Acceso Basado en Roles (RBAC):

*   **Administrador Privilegiado**: Acceso total al inventario, mantenimientos y panel de **Gestión de Usuarios**.
*   **Técnico Editor**: Permisos de gestión operativa (CRUD de hardware y registros técnicos).

---

## 🌐 Despliegue en Producción

El entorno de ejecución estable se encuentra disponible en:

👉 **[Hardware Hub Pro v1.2 - Producción](https://alumno16.dwes.site/)**

---

## 📧 Soporte y Autoría

Desarrollado con pasión por el detalle y la excelencia técnica.

**Desarrollador Web**: Juanjo Acevedo
**Año**: 2026
**Ubicación**: I.E.S.-Cristóbal de Monroy

---
*Este proyecto forma parte de la certificación técnica en Aplicaciones Web.*
