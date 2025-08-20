# Sistema de Agendamiento de Visitas - Institución Educativa

## Descripción del Proyecto

Este es un sistema web desarrollado en Laravel 12 para la gestión automatizada de visitas y tours en una institución educativa. El sistema permite a empresas, universidades y otras instituciones solicitar visitas, mientras que los administradores pueden gestionar, aprobar y coordinar estas solicitudes.

## Características Principales

### 👥 Roles de Usuario
- **Visitante**: Puede solicitar visitas y comunicarse con administradores
- **Administrador**: Gestiona visitas aprobadas y coordina la ejecución
- **Super Administrador**: Control total del sistema, puede aprobar/rechazar visitas y asignar permisos

### 🔄 Flujo de Trabajo
1. **Solicitud**: El visitante completa un formulario detallado
2. **Revisión**: El SuperAdmin revisa y puede asignar a un Administrador
3. **Negociación**: Chat privado entre visitante y administrador
4. **Aprobación**: Confirmación de fecha, horario y actividades
5. **Ejecución**: Seguimiento de la visita realizada

### 📋 Funcionalidades Clave
- Formulario completo de solicitud de visita
- Sistema de chat privado para negociaciones
- Gestión de actividades y horarios disponibles
- Sistema de permisos granulares
- Logs de auditoría completos
- Integración con servicio de restaurante
- Manejo de requisitos especiales (vestimenta, equipamiento)

## Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM (para assets)

## Instalación

### 1. Clonar el Repositorio
```bash
git clone [URL_DEL_REPOSITORIO]
cd Visitas
```

### 2. Instalar Dependencias
```bash
composer install
npm install
```

### 3. Configurar Variables de Entorno
```bash
cp .env.example .env
```

Editar el archivo `.env` con la configuración de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visitas_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 4. Generar Clave de Aplicación
```bash
php artisan key:generate
```

### 5. Ejecutar Migraciones y Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 6. Compilar Assets (Opcional)
```bash
npm run dev
```

### 7. Configurar Servidor Web
Asegúrate de que el directorio `public` sea el document root de tu servidor web.

## Datos de Acceso Inicial

### Super Administrador
- **Email**: superadmin@institucion.com
- **Password**: password123

### Usuario de Prueba
- **Email**: test@example.com
- **Password**: password

## Estructura de la Base de Datos

### Tablas Principales

#### Usuarios y Roles
- `users` - Usuarios del sistema
- `roles` - Roles disponibles (visitante, administrador, superadmin)
- `permissions` - Permisos del sistema
- `user_roles` - Relación usuarios-roles
- `user_permissions` - Permisos especiales otorgados

#### Actividades y Horarios
- `visit_activities` - Actividades disponibles (mecanización, laboratorios, etc.)
- `visit_schedules` - Horarios disponibles por día

#### Visitas
- `visits` - Solicitudes de visita principales
- `visit_activities_visits` - Actividades seleccionadas por visita
- `visit_messages` - Chat privado entre visitante y admin
- `visit_attendees` - Lista de asistentes
- `visit_logs` - Logs de auditoría

## Formulario de Solicitud de Visita

El formulario incluye los siguientes campos:

### Información de la Institución
- Nombre de la institución/empresa
- Persona de contacto
- Email y teléfono de contacto
- Cargo de la persona de contacto
- Descripción de la institución
- Tipo de institución (Universidad, Empresa, Colegio, etc.)

### Detalles de la Visita
- Número de participantes esperados
- Fecha y horario preferido
- Propósito de la visita
- Requisitos especiales
- Actividades de interés

### Servicios Adicionales
- Servicio de restaurante ($12,000 por persona)
- Número de personas para restaurante
- Notas especiales para el restaurante

## Actividades Disponibles

Basadas en el cronograma real de la institución:

1. **Mecanización Agrícola y Pecuaria** (4 horas)
   - Instructor: Edwin Ramírez Vasquez
   - Requisitos: Ropa cómoda, zapatos cerrados, camisa manga larga

2. **Práctica de Campo - Operación de Maquinaria** (3 horas)
   - Instructor: Edwin Ramírez Vasquez
   - Requisitos: Botas industriales o de goma

3. **Sistemas de Riego y Drenajes** (4.5 horas)
   - Instructor: Juan de Dios Nañez
   - Requisitos: Ropa cómoda, zapatos cerrados, gorra

4. **Recorrido por Unidades Pecuarias** (3 horas)
   - Instructor: Gestores Sena Empresa
   - Requisitos: Botas industriales o de goma obligatorias

5. **Manejo de Calidad en Cacao** (2 horas)
   - Instructor: Kathryn Yadira Guzman
   - Requisitos: Ropa cómoda, zapatos cerrados

6. **Práctica de Laboratorio de Biotecnología** (1.5 horas)
   - Instructor: Kathryn Yadira Guzman
   - Requisitos: Batas de laboratorio obligatorias

7. **Práctica de Laboratorio de Suelo** (1.5 horas)
   - Instructor: Kathryn Yadira Guzman
   - Requisitos: Batas de laboratorio obligatorias

8. **Tour General de la Institución** (2 horas)
   - Instructor: Gestores Sena Empresa
   - Requisitos: Ropa cómoda, zapatos cerrados, gorra

## Estados de las Visitas

- **pending**: Pendiente de revisión
- **under_review**: En revisión/negociación
- **approved**: Aprobada
- **rejected**: Rechazada
- **completed**: Completada
- **cancelled**: Cancelada

## Comandos Útiles

### Gestión de Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Revertir migraciones
php artisan migrate:rollback

# Ejecutar seeders
php artisan db:seed

# Ejecutar seeder específico
php artisan db:seed --class=SuperAdminSeeder

# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Desarrollo
```bash
# Servidor de desarrollo
php artisan serve

# Compilar assets en modo desarrollo
npm run dev

# Compilar assets para producción
npm run build

# Ejecutar tests
php artisan test
```

## Seguridad

### Características de Seguridad Implementadas
- Autenticación robusta con Laravel
- Sistema de roles y permisos granulares
- Validación de datos en frontend y backend
- Protección CSRF
- Sanitización de datos de entrada
- Logs de auditoría completos
- Contraseñas hasheadas

### Recomendaciones de Seguridad
1. Cambiar las contraseñas por defecto
2. Configurar HTTPS en producción
3. Configurar firewall y acceso a la base de datos
4. Realizar backups regulares
5. Mantener Laravel y dependencias actualizadas

## Personalización

### Modificar Actividades
Edita el archivo `database/seeders/VisitActivitySeeder.php` para agregar o modificar actividades.

### Modificar Horarios
Edita el archivo `database/seeders/VisitScheduleSeeder.php` para ajustar los horarios disponibles.

### Agregar Campos al Formulario
1. Crear migración para agregar campos a la tabla `visits`
2. Actualizar el modelo `Visit`
3. Modificar los controladores y vistas correspondientes

## Soporte

Para soporte técnico o preguntas sobre el sistema, contacta al equipo de desarrollo.

## Licencia

Este proyecto es propiedad de la institución educativa y está destinado para uso interno.

---

**Desarrollado con Laravel 12** 🚀
