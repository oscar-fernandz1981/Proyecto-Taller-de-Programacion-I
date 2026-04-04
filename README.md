<img width="450" height="378" alt="image" src="https://github.com/user-attachments/assets/a5e6f063-7980-4aa5-938c-8f3a8ad3ab94" />
<img width="464" height="464" alt="image" src="https://github.com/user-attachments/assets/07484959-681d-4c86-9242-2e997ddbd81b" />

Facultad de Ciencias Exactas y Naturales y Agrimensura
Licenciatura en Sistemas de Información
Taller de Programación I
Especificación de Requerimientos – Proyecto Multirubro BLASS
Fernandez, R. Oscar

ESPECIFICACIÓN DE REQUISITOS DE SOFTWARE (ERS) - PROYECTO BLASS
## Tabla de Contenidos
1. [INTRODUCCIÓN](#INTRODUCCIÓN)
1.1 [Propósito](#Propósito)
1.2 [Alcance](#Alcance)	
2. [DESCRIPCIÓN-GENERAL](#DESCRIPCIÓN-GENERAL)
2.1 [Perspectiva-del-Producto](#Perspectiva-del-Producto)
2.2 [Funciones-del-Producto](#Funciones-del-Producto)
2.3 [Características-de-los-Usuarios](#Características-de-los-Usuarios)
3. [REQUISITOS-ESPECÍFICOS-(IEEE830)](#REQUISITOS-ESPECÍFICOS-(IEEE830))
3.1 [Requisitos-Funcionales](#Requisitos-Funcionales)
3.2 [Requisitos-No-Funcionales](#Requisitos-No-Funcionales)
4. [INTERFACES](#INTERFACES)
4.1 [Interfaz-de-Usuario](#Interfaz-de-Usuario)
4.2 [Interfaz-de-Software](#Interfaz-de-Software)
5. [MODELADO-DE-DATOS-(Descripción-Técnica)](#MODELADO-DE-DATOS-(Descripción-Técnica))
6. [CONCLUSIÓN](#CONCLUSIÓN)



________________________________________
ESPECIFICACIÓN DE REQUISITOS DE SOFTWARE (ERS) - PROYECTO BLASS
Proyecto: Sitio de Compras Online Multirubro BLASS
Autor: Fernandez, R. Oscar
Fecha: Febrero 2026
Versión: 2.0 (Final)
________________________________________

## INTRODUCCIÓN

## Propósito
El presente documento define los requisitos funcionales y no funcionales para el sistema de gestión de ventas y catálogo online "Multirubro BLASS". Está dirigido al equipo docente para la evaluación final de la cátedra.

## Alcance
El sistema permite la gestión integral de productos, el registro de usuarios, la simulación de compras mediante un carrito y la generación de comprobantes en formato PDF.


________________________________________

## DESCRIPCIÓN GENERAL

## Perspectiva del Producto
El sistema funciona como una aplicación web autónoma bajo el patrón Modelo-Vista-Controlador (MVC), interactuando con una base de datos relacional MySQL.

## Funciones del Producto
•	Gestión de Usuarios: Registro, login y perfiles (Admin y Cliente).
•	Gestión de Catálogo: CRUD (Alta, Baja, Modificación y Listado) de productos con categorías.
•	Proceso de Compra: Selección de productos, gestión de cantidades en carrito y confirmación de pedido.
•	Facturación: Generación automática de facturas PDF tras la compra.
•	Contacto: Formulario para consultas de usuarios hacia la administración.

## Características de los Usuarios
•	Administrador: Control total del inventario, gestión de stock y visualización de ventas.
•	Cliente: Navegación por catálogo, compra de productos y acceso a su historial de facturación.
•	Visitante: Solo visualización de productos y acceso a formularios de contacto/registro.


________________________________________

## REQUISITOS ESPECÍFICOS (IEEE 830)

## Requisitos Funcionales
•	RF-01 (Autenticación): El sistema debe permitir el ingreso diferenciado mediante correo y contraseña.
•	RF-02 (Gestión de Productos): El administrador podrá realizar el alta de productos cargando nombre, descripción, precio, stock y una imagen.
•	RF-03 (Carrito de Compras): El sistema permitirá al cliente agregar múltiples ítems, calculando subtotales y totales automáticamente.
•	RF-04 (Control de Stock): Al confirmar una compra, el sistema debe descontar automáticamente las unidades del inventario.
•	RF-05 (Generación de PDF): El sistema utilizará la librería Dompdf para emitir un comprobante legal de la transacción.
•	RF-06 (Seguridad): Uso de Filtros (Filters) para restringir el acceso a rutas de administración a usuarios no autorizados.


## Requisitos No Funcionales
•	RNF-01 (Arquitectura): Implementado en PHP 8.x bajo el framework CodeIgniter 4.
•	RNF-02 (Interfaz): Diseño responsivo utilizando Bootstrap 5.
•	RNF-03 (Persistencia): Motor de base de datos MySQL (MariaDB).
•	RNF-04 (Usabilidad): Implementación de DataTables para búsqueda y filtrado rápido en listas.




________________________________________

## INTERFACES

## Interfaz de Usuario
El diseño se basa en una paleta de colores profesional, con un carrusel dinámico en el inicio y tarjetas (cards) informativas para los productos.

## Interfaz de Software
•	Dompdf: Para la exportación de documentos.
•	CodeIgniter Cart: Para la persistencia temporal de los productos seleccionados.





________________________________________

## MODELADO DE DATOS (Descripción Técnica)

El sistema se basa en 5 entidades principales:
1.	Usuarios: Almacena credenciales y perfil_id.
2.	Productos: Datos técnicos y estado de "eliminado" (baja lógica).
3.	Categorías: Clasificación (Termos, Auriculares, Juguetes).
4.	Ventas Cabecera: Datos generales del pedido (Fecha, Usuario, Total).
5.	Ventas Detalle: Relación N a N que detalla productos y cantidades por cada venta.


<img width="924" height="689" alt="modelado de datos" src="https://github.com/user-attachments/assets/e2ea783f-d202-4abd-b63a-920a1c5221f2" />





________________________________________

## CONCLUSIÓN
El sistema cumple con los objetivos de un CRUD avanzado, integrando lógica de negocio compleja como el manejo de stock y seguridad por niveles, proporcionando una solución escalable para un comercio minorista.


