<?php
// URL base para las peticiones a la API de Mobilia
define('MOBILIA_BASE_URL', 'http://54.145.54.14:8080/mobilia-test/ws/Extra');

// API Key para autenticación (define aquí tu clave real)
define('MOBILIA_API_KEY', 'b337103d-34e9-4ea6-8b80-21b86592532d'); // <-- Reemplaza por tu API Key

// Parámetros permitidos para las consultas a la API
function mobilia_allowed_params() {
  return [
    'operation',        // Tipo de operación (venta, alquiler, etc.)
    'propertyTypeCode', // Código de tipo de propiedad
    'sectorCode',       // Código de sector o zona
    'fromRooms', 'toRooms', // Rango de habitaciones
    'fromArea', 'toArea',   // Rango de área
    'fromPrice', 'toPrice', // Rango de precio
    'forRent',          // Indicador de alquiler
    'onSale',           // Indicador de venta
    'branchCode'        // Código de sucursal
  ];
}