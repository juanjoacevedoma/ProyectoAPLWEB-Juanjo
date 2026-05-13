# Proyecto APLWEB - Hardware Hub Professional 🛡️

Dashboard profesional de gestión de inventario y mantenimiento de hardware para sistemas corporativos.

## 🚀 Descripción
Esta aplicación permite el control total sobre un catálogo de componentes de hardware, facilitando el seguimiento de stock, la gestión de marcas y el registro detallado de intervenciones de mantenimiento. Diseñada con una estética **Corporate Pro** basada en Glassmorphism y visualización de datos moderna.

### Características Principales:
- **Gestión CRUD**: Registro completo de componentes y mantenimientos (Protegido por login).
- **Control de Acceso**: Sistema de autenticación para asegurar la integridad de los datos.
- **Analítica en Tiempo Real**: Dashboards visuales para stock y estado de equipos.
- **Interfaz Premium**: Diseño responsive, modo oscuro y efectos visuales avanzados.
- **Seguridad**: Configuración protegida mediante archivos de entorno y exclusiones de Git.

## 🔐 Roles y Accesos
Para acceder a las funciones de gestión, el sistema implementa dos niveles de permisos:

| Rol | Funciones |
| :--- | :--- |
| **Administrador** | Control total del sistema + **Gestión de Usuarios**. |
| **Editor** | Gestión completa del inventario y mantenimientos. |

### Credenciales de Acceso (Test):
- **Administrador**: `admin` / `admin123`
- **Editor**: `prueba` / `admin123`

## 🛠️ Tecnologías Utilizadas
- **Backend**: PHP 8.2 (PDO para conexiones seguras).
- **Frontend**: HTML5, CSS3 (Custom Variables, Flexbox, Grid), JavaScript (ES6+).
- **Base de Datos**: MySQL / MariaDB.
- **Servidor**: Apache (XAMPP / Producción dwes.site).

## ⚙️ Instalación y Configuración

### 1. Requisitos previos
- Servidor web (Apache/Nginx).
- PHP 8.0 o superior.
- MySQL/MariaDB.

### 2. Configuración de la Base de Datos
1. Accede a tu gestor de base de datos (ej. phpMyAdmin).
2. Crea una nueva base de datos llamada `catalogo_hardware` (o el nombre que prefieras).
3. Importa el archivo `database.sql` ubicado en la raíz del proyecto para generar la estructura y los datos de prueba.

### 3. Configuración del Proyecto
1. Clona el repositorio en tu carpeta de servidor local (`htdocs` o `www`).
2. Localiza el archivo `config.example.php`.
3. Renómbralo a `config.php`.
4. Edita las variables `$dbname`, `$user` y `$pass` con tus credenciales locales.

```php
$dbname = "tu_db_nombre";
$user = "tu_usuario";
$pass = "tu_password";
```

## 🌐 Enlace a Producción
Puedes ver el proyecto desplegado en el siguiente enlace:
👉 **[Hardware Hub Pro - alumno16.dwes.site](https://alumno16.dwes.site/)**

---
*Desarrollado por Juanjo Acevedo - 2026*
