# Sistema de Tickets de Soporte Técnico

## Descripción
Este es un sistema de gestión de tickets de soporte técnico desarrollado con Laravel, que permite a los clientes crear tickets de soporte y a los técnicos gestionarlos de manera eficiente.

## Tecnologías Utilizadas
- **Framework**: Laravel 10
- **Frontend**: Blade Templates + Tailwind CSS
- **Autenticación**: Laravel Fortify + Jetstream
- **Base de Datos**: MySQL

## Características Principales

### Roles de Usuario
- **Administrador**: Gestión completa del sistema
- **Técnico**: Atención y resolución de tickets
- **Cliente**: Creación y seguimiento de tickets

### Funcionalidades
1. **Gestión de Usuarios**
   - Registro de usuarios con roles (Cliente/Técnico)
   - Autenticación segura
   - Perfiles de usuario

2. **Gestión de Tickets**
   - Creación de tickets por clientes
   - Asignación de técnicos a tickets
   - Actualización de estado de tickets
   - Eliminación de tickets por clientes o administradores

3. **Interfaz Responsiva**
   - Diseño adaptable a dispositivos móviles
   - Navegación intuitiva
   - Menús específicos según rol

## Estructura de la Base de Datos

### Tablas Principales
- **users**: Almacena información de usuarios
- **roles**: Define los roles del sistema
- **tickets**: Almacena los tickets de soporte

## Instalación

1. Clonar el repositorio
2. Instalar dependencias:
   ```
   composer install
   npm install
   ```
3. Configurar el archivo .env con las credenciales de la base de datos
4. Ejecutar migraciones:
   ```
   php artisan migrate
   ```
5. Ejecutar seeders (opcional):
   ```
   php artisan db:seed
   ```
6. Iniciar el servidor:
   ```
   php artisan serve
   ```

## Uso

### Para Clientes
1. Registrarse como cliente
2. Crear tickets de soporte
3. Ver estado de tickets
4. Eliminar tickets propios

### Para Técnicos
1. Registrarse como técnico
2. Ver tickets asignados
3. Actualizar estado de tickets

### Para Administradores
1. Gestionar todos los tickets
2. Asignar técnicos
3. Eliminar cualquier ticket

## Seguridad
- Autenticación robusta con Laravel Fortify
- Protección CSRF en formularios
- Validación de roles y permisos
- Middleware de autenticación en rutas protegidas
