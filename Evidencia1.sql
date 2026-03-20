CREATE DATABASE IF NOT EXISTS EVIDENCIA_1;

-- DROP DATABASE EVIDENCIA_1; -- Para eliminar la base de datos si es necesario y volver a crearla desde cero

USE EVIDENCIA_1;

/* 

“Halcon” es un distribuidor de materiales de construcción que requiere una aplicación web para automatizar sus procesos internos. Tras una entrevista, las necesidades del cliente son las siguientes:

•	Una aplicación web que permita a los clientes ver el estado de sus pedidos desde una pantalla principal donde el cliente introduce un número de cliente y un número de factura. La información que se mostrará es el estado y, en caso de tener estado “Entregado”, mostrar la foto como evidencia de la entrega. Los estados son los siguientes: 
•	Solicitado: cuando se solicita un material y el ejecutivo de ventas lo ingresa en el sistema.
•	En proceso: cuando el pedido está en stock y se está preparando para salir a ruta o, en su defecto, cuando no está en stock y debe comprarse a un proveedor externo.
•	En ruta: cuando el pedido ha sido asignado para distribución.
•	Entregado: cuando el pedido ha sido entregado en las instalaciones del cliente.

•	El personal que trabaja en la empresa puede acceder a un panel administrativo para realizar sus respectivas actividades. Esto requiere lo siguiente:

•	Que el sistema incluya por defecto un usuario administrativo, el cual podrá registrar nuevos usuarios y asignar roles a los mismos.
•	Los roles corresponden a los departamentos (importante: los clientes no podrán registrarse):
•	Ventas: encargados de tomar los pedidos de los clientes.
•	Compras: en caso de no tener algún material, estos usuarios gestionan la compra de los materiales.
•	Almacén: gestionan el almacén y preparan los pedidos para la ruta, además informan a Compras sobre materiales inexistentes o con stock bajo.
•	Ruta: encargados de distribuir los pedidos a los clientes.

•	Se respeta el ciclo de vida de un pedido:

1.	Un cliente llama a la empresa para realizar un pedido.
2.	El vendedor toma el pedido y registra una nueva entrada en la plataforma, la cual debe contener lo siguiente:
a.	Número de factura consecutivo al que corresponderá el pedido.
b.	Nombre o razón social del cliente que realiza el pedido.
c.	Un número único de cliente que será asignado de manera arbitraria.
d.	Datos fiscales del cliente para el llenado de la factura física que posteriormente será enviada por correo electrónico (la aplicación no enviará facturas; cada pedido está vinculado a un número de factura, pero una persona de administración se encarga de elaborarlas por separado).
e.	Fecha y hora del pedido.
f.	Dirección de entrega del pedido.
g.	Un campo para ingresar notas o información adicional.
3.	El estado predeterminado que adquiere el pedido después de ser registrado es “Pedido”. En ese momento, el pedido debe ser visible para todos los empleados de la empresa.
4.	Una persona de almacén debe encargarse del pedido y cambiar su estado a “En proceso”. Una vez que haya terminado de reunir los materiales (del almacén interno o coordinando con compras la adquisición del producto faltante), deberá cambiar el estado a “En ruta” y, a su vez, cargar físicamente la unidad junto con el transportista.
5.	La persona de ruta debe tomar una foto de la unidad cargada y subirla a la plataforma (considerar que la opción de subir fotos solo debe ser visible para el personal del departamento de Ruta).
6.	Al realizar la entrega, el operador debe tomar otra foto del material descargado y subirla a la plataforma como evidencia de entrega.
7.	Una vez entregado el material, el estado cambia a “Entregado”.

a.	Una pantalla donde se muestren todos los pedidos, con la posibilidad de buscarlos por Número de Factura, Número de Cliente, Fecha o Estado.

b.	Al acceder a un pedido, este puede ser modificado o eliminado lógicamente; no se elimina de la base de datos, sino que se le asigna un estado para que no se muestre junto con los demás pedidos.

c.	Una pantalla donde se muestren los pedidos eliminados, con la posibilidad de editarlos y restaurarlos.

*/ 

-- Crear tabla de direccion LISTO

-- Crear tabla de historial del panel administrativo LISTO

-- Separar estado en una tabla aparte LISTO

-- Tabla stock y almacenes e historial del almacen LISTO

-- Tabla de proveedores y tabla de materias LISTO

-- Tabla de compra Listo

-- Tabla factura LISTO

-- TABLA DE DETALLE E HISTORIAL DE factura LISTO

CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreRol VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreUsuario VARCHAR(50) NOT NULL UNIQUE,
    contraseña VARCHAR(60) NOT NULL,
    nombrePila VARCHAR(50) NOT NULL, -- Para almacenar el nombre de pila del usuario
    nombreApellido VARCHAR(50) NOT NULL, -- Para almacenar el apellido del usuario
    rolId INT, 
    activo BOOLEAN DEFAULT TRUE, -- Para marcar usuarios como activos o inactivos
    FOREIGN KEY (rolId) REFERENCES roles(id)
);

CREATE TABLE IF NOT EXISTS direcciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    calle VARCHAR(150) NOT NULL,
    numeroExterior VARCHAR(20) NOT NULL,
    numeroInterior VARCHAR(20), -- Opcional
    colonia VARCHAR(150) NOT NULL,
    ciudad VARCHAR(150) NOT NULL,
    municipio VARCHAR(150) NOT NULL,
    estado VARCHAR(150) NOT NULL,
    pais VARCHAR(100) NOT NULL,
    codigoPostal VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS estadoclientes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreEstado ENUM('Pedido', 'Solicitado', 'En proceso', 'En ruta', 'Entregado', 'Eliminado') NOT NULL
);

CREATE TABLE IF NOT EXISTS estadoHistoriales(
    id INT AUTO_INCREMENT PRIMARY KEY,
    anteriorEstado ENUM('Pedido', 'Solicitado', 'En proceso', 'En ruta', 'Entregado', 'Eliminado') NOT NULL,
    nuevoEstado ENUM('Pedido', 'Solicitado', 'En proceso', 'En ruta', 'Entregado', 'Eliminado') NOT NULL
);

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numeroCliente VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    correoElectronico VARCHAR(320) NOT NULL, -- El límite máximo para un correo electrónico es de 320 caracteres
    activo BOOLEAN DEFAULT TRUE, -- Para marcar clientes como activos o inactivos
    registroFecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    direccionesID INT NOT NULL, -- Para almacenar la dirección del cliente
    -- Para almacenar la fecha y hora de registro del cliente en la base de datos
    -- Se eliminan los campos relacionados con la dirección, ya que se manejarán en una tabla aparte
    FOREIGN KEY (direccionesID) REFERENCES direcciones(id)
);

CREATE TABLE IF NOT EXISTS clienteFacturas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    clienteId INT NOT NULL,
    numeroFactura VARCHAR(50) NOT NULL UNIQUE,
    nombreRazonSocial VARCHAR(255) NOT NULL, -- Para almacenar el nombre o razón social del cliente
    RFC VARCHAR(13) NOT NULL,
    regimenFiscal VARCHAR(255) NOT NULL,
    fechaFactura DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora de emisión de la factura
    FOREIGN KEY (clienteId) REFERENCES clientes(id)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numeroFactura VARCHAR(50) NOT NULL UNIQUE,
    clienteId INT NOT NULL, -- Cliente que realiza el pedido
    fechaPedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora del pedido por el cliente
    -- direccionEntrega VARCHAR(255) NOT NULL, -- No cumple 1FN 

    notas TEXT, -- Notas para información adicional
    -- CUANDO SE HAGA EL PEDIDO VA A HACER ID 1, DEFAULT 'PEDIDO'
    estadosID INT,
    usuariosId INT, -- Usuario que registró el pedido
    activo BOOLEAN DEFAULT TRUE, -- Para marcar pedidos como activos o inactivos
    creadoEn DATETIME DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora de creación del pedido en la base de datos
    FOREIGN KEY (estadosId) REFERENCES estadoclientes(id),
    FOREIGN KEY (clienteId) REFERENCES clientes(id),
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProveedor VARCHAR(255) NOT NULL, -- Para almacenar el nombre del proveedor
    telefono VARCHAR(20) NOT NULL, -- Para almacenar el teléfono del proveedor
    correoElectronico VARCHAR(320) NOT NULL, -- Para almacenar el correo electrónico del proveedor
    activo BOOLEAN DEFAULT TRUE, -- Para marcar proveedores como activos o inactivos
    registroFecha DATETIME DEFAULT CURRENT_TIMESTAMP -- Para almacenar la fecha y hora de registro del proveedor en la base de datos
);

CREATE TABLE IF NOT EXISTS materiales(
    id INT AUTO_INCREMENT PRIMARY KEY,
    claveMaterial INT NOT NULL UNIQUE, -- Para almacenar la clave única del material
    descripcionMaterial TEXT NOT NULL, -- Para almacenar la descripción del material
    precioUnitario INT NOT NULL,-- Para almacenar el precio unitario del material
    cantidadMaterial INT NOT NULL -- Para almacenar la cantidad de material disponible en el almacén
);

CREATE TABLE IF NOT EXISTS stockAlmacenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materialesId INT NOT NULL, -- Para almacenar el material del que se está registrando el stock
    cantidadStock INT NOT NULL, -- Para almacenar la cantidad de material disponible en el almacén
    stockMinimo INT NOT NULL, -- Para almacenar la cantidad mínima de material que debe haber en el almacén antes de generar una alerta para compras
    stockMaximo INT NOT NULL, -- Para almacenar la cantidad máxima de material que puede haber en el almacén para evitar sobrestock
    fechaActualizacion DATETIME DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora de la última actualización del stock
    FOREIGN KEY (materialesId) REFERENCES materiales(id) 
);

CREATE TABLE IF NOT EXISTS almacenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreAlmacen VARCHAR(100) NOT NULL, -- Para almacenar el nombre del almacén
    direccionesID INT NOT NULL, -- Para almacenar la dirección del almacén
    stockId INT NOT NULL, -- Para almacenar el stock del almacén
    proveedoresID INT NOT NULL, -- Para almacenar el proveedor del almacén
    FOREIGN KEY (proveedoresID) REFERENCES proveedores(id), -- Relación con la tabla de proveedores
    FOREIGN KEY (stockId) REFERENCES stockAlmacenes(id), -- Relación con la tabla de stock de almacenes
    FOREIGN KEY (direccionesID) REFERENCES direcciones(id) 
);

CREATE TABLE IF NOT EXISTS detalleFacturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clienteFacturasId INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL, -- Para almacenar el total (cantidad * precio unitario) del material o servicio facturado
    materialesID INT NOT NULL, -- Para almacenar el material o servicio facturado
    FOREIGN KEY (materialesID) REFERENCES materiales(id), -- Relación con la tabla de 
    FOREIGN KEY (clienteFacturasId) REFERENCES clienteFacturas(id)
);

CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materialesId INT NOT NULL, -- Para almacenar el material que se está comprando
    cantidadComprada INT NOT NULL, -- Para almacenar la cantidad de material que se está comprando
    precioCompra DECIMAL(10, 2) NOT NULL, -- Para almacenar el precio de compra del material
    proveedoresId INT NOT NULL, -- Para almacenar el proveedor al que se le está comprando el material
    usuariosId INT NOT NULL, -- Que usuario realizó la compra
    fechaCompra DATETIME DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora de la compra
    FOREIGN KEY (materialesId) REFERENCES materiales(id),
    FOREIGN KEY (proveedoresId) REFERENCES proveedores(id),
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS historialAlmacenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materialesId INT NOT NULL, -- Para almacenar el material del que se está registrando el historial
    cantidadAnterior INT NOT NULL, -- Para almacenar la cantidad de material antes de la actualización del stock
    cantidadNueva INT NOT NULL, -- Para almacenar la cantidad de material después de la actualización del stock
    usuariosId INT NOT NULL, -- Que usuario realizó el cambio en el stock
    fechaCambio DATETIME DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora del cambio en el stock
    FOREIGN KEY (materialesId) REFERENCES materiales(id),
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS historialFacturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clienteFacturasId INT NOT NULL,
    usuariosId INT NOT NULL, -- Que usuario realizó el cambio de estado
    estadosHistorialId INT NOT NULL, -- Para almacenar el estado anterior y el nuevo estado de la factura
    fechaCambio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (clienteFacturasId) REFERENCES clienteFacturas(id),
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id),
    FOREIGN KEY (estadosHistorialId) REFERENCES estadoHistoriales(id)
);

CREATE TABLE IF NOT EXISTS historialPedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedidoId INT NOT NULL,
    usuariosId INT NOT NULL, -- Que usuario realizó el cambio de estado
    -- Se crea una tabla aparte para el historial de estados
    estadosHistorialId INT NOT NULL, -- Para almacenar el estado anterior y el nuevo estado del pedido
    fechaCambio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedidoId) REFERENCES pedidos(id),
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id),
    FOREIGN KEY (estadosHistorialId) REFERENCES estadoHistoriales(id)
);

CREATE TABLE IF NOT EXISTS historialAdministrativos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuariosId INT NOT NULL, -- Que usuario realizó la acción administrativa
    accion VARCHAR(255) NOT NULL, -- Descripción de la acción realizada
    fechaAccion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS evidenciasFotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedidoId INT NOT NULL,
    usuariosId INT NOT NULL, -- Que usuario subió la foto    
    tipo ENUM('Carga', 'Entrega') NOT NULL, -- Para diferenciar entre fotos de carga y fotos de entrega
    urlFoto VARCHAR(255) NOT NULL, -- Para almacenar la URL o ruta de la foto, 
    fechaSubida DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedidoId) REFERENCES pedidos(id),
    FOREIGN KEY (usuariosId) REFERENCES usuarios(id)
);

-- INSERTS DE PRUEBA

INSERT INTO roles (nombreRol) VALUES 
('Administrador'),
('Ventas'),
('Compras'),
('Almacén'),
('Ruta');

INSERT INTO usuarios (nombreUsuario, contraseña, nombrePila, nombreApellido, rolId) VALUES 
('admin', 'admin123', 'Admin', 'User', 1); -- Usuario administrativo por defecto

INSERT INTO clientes (numeroCliente, nombreRazonSocial, RFC, calle, numeroExterior, colonia, ciudad, municipio, estado, pais, codigoPostal, regimenFiscal, telefono, correoElectronico) VALUES 
('C001', 'Constructora ABC S.A. de C.V.', 'ABC123456789', 'Calle Falsa', '123', 'Colonia Falsa', 'Ciudad Falsa', 'Municipio Falso', 'Estado Falso', 'País Falso', '12345', 'Régimen General de Ley Personas Morales', '555-1234', 'contacto@constructoraabc.com');

INSERT INTO pedidos (numeroFactura, clienteId, calleEntrega, numeroExteriorEntrega, coloniaEntrega, ciudadEntrega, municipioEntrega, estadoEntrega, paisEntrega, codigoPostalEntrega, notas, usuariosId) VALUES 
('F001', 1, 'Calle Falsa', '123', 'Colonia Falsa', 'Ciudad Falsa', 'Municipio Falso', 'Estado Falso', 'País Falso', '12345', 'Entregar entre 9am y 5pm', 1); -- Pedido registrado por el usuario administrativo

INSERT INTO historialPedidos (pedidoId, usuariosId, estadoAnterior, estadoNuevo) VALUES 
(1, 1, 'Pedido', 'Pedido'); -- Historial inicial del pedido

INSERT INTO evidenciasFotos (pedidoId, usuariosId, tipo, urlFoto) VALUES 
(1, 1, 'Carga', 'http://example.com/fotos/carga1.jpg'); -- Foto de carga para el pedido 1

CREATE OR REPLACE VIEW vista_pedidos_con_fotos AS
SELECT 
    p.id AS pedidoId,
    p.numeroFactura,
    p.fechaPedido,
    p.estado,
    p.notas,
    p.creadoEn,

    -- Cliente
    c.numeroCliente,
    c.nombreRazonSocial,
    c.RFC,

    -- Dirección de entrega
    CONCAT(p.calleEntrega, ' ', p.numeroExteriorEntrega,
           IF(p.numeroInteriorEntrega IS NOT NULL, CONCAT(' Int ', p.numeroInteriorEntrega), ''),
           ', ', p.coloniaEntrega, ', ', p.ciudadEntrega, ', ', p.estadoEntrega, ', CP ', p.codigoPostalEntrega)
           AS direccionEntregaCompleta,

    -- Usuario que registró el pedido
    CONCAT(u.nombrePila, ' ', u.nombreApellido) AS usuarioRegistro,
    r.nombreRol AS rolUsuario,

    -- Fotos
    ef.tipo AS tipoFoto,
    ef.urlFoto AS urlFoto,
    ef.fechaSubida AS fechaFoto

FROM pedidos p
INNER JOIN clientes c ON p.clienteId = c.id
INNER JOIN usuarios u ON p.usuariosId = u.id
INNER JOIN roles r ON u.rolId = r.id
LEFT JOIN evidenciasFotos ef ON ef.pedidoId = p.id;

SELECT * FROM vista_pedidos_con_fotos; -- Para verificar que la vista existe y muestra la información deseada