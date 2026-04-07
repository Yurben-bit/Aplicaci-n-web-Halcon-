# Descripción General
Halcón es un distribuidor de materiales de construcción que necesitaba una aplicación web para automatizar sus procesos internos.
Este proyecto permite que los clientes consulten el estado de sus órdenes y que el personal de la empresa gestione el ciclo completo de las mismas desde un Dashboard administrativo.

# Funcionalidades 
### Portal de Clientes
- Consulta de órdenes mediante Número de Cliente y Número de Factura.
- Visualización del estado de la orden:
- Ordered → Orden registrada por Ventas.
- In Process → Materiales preparados o adquiridos.
- In Route → Orden enviada a distribución.
- Delivered → Orden entregada con evidencia fotográfica.
- Visualización de fotos de evidencia cuando la orden está en estado Delivered.

# Dashboard Administrativo
- Usuario Administrador por defecto con capacidad de registrar nuevos usuarios y asignar roles.

### Roles disponibles:
- Admin → Tiene todos los permisos.
- Ventas → Registro de órdenes de clientes.
- Compras → Gestión de adquisición de materiales externos.
- Almacén → Preparación de órdenes y reporte de faltantes.
- Ruta → Distribución de órdenes y carga de fotos de evidencia.
- Cliente → Puede rastrear su orden actual y anteriores, asi como ver la evidencia fotográfica de la entrega.

## Gestión del ciclo de vida de las órdenes:
- Registro de nueva orden con datos fiscales, dirección de entrega, notas y consecutivo de factura.
- Actualización de estados según el flujo de trabajo.
- Subida de fotos de carga y entrega (solo usuarios de Ruta).

## Administración de órdenes:
- Búsqueda por Número de Factura, Número de Cliente, Fecha o Estado.
- Modificación o eliminación lógica (soft delete).
- Visualización de órdenes eliminadas con opción de editar o restaurar.

# Implementación Técnica
- Frameworks: Laravel (Blade) 
- Modelos y Controladores: creados para órdenes, usuarios, roles y estados.
- Vistas: completas y con diseño atractivo usando Bootstrap.
- Registro de Usuarios: solo administradores pueden registrar y asignar roles.
- Protección de Vistas: acceso restringido según rol.
- Eliminación Lógica: las órdenes no se borran de la BD, solo se marcan como eliminadas.

# Cambios Realizados
- Creación de modelos, controladores, vistas y registro de usuarios.
- Implementación de roles y permisos por departamento.
- Desarrollo del ciclo de vida de órdenes con estados dinámicos.
- Configuración de búsqueda y restauración de órdenes eliminadas.
- Actualización del proyecto en GitHub con este README detallado.
