<?php

$connectionString = "file:prova.log";

// Parseamos la URL de conexión
$urlData = parse_url($connectionString);

var_dump($urlData);

if (!isset($urlData['scheme'])) {
    throw new Exception("Conexión con esquema inválido.\n");
}

// Ajustamos la ruta relativa para incluir el archivo correctamente
$fileName = __DIR__ . '/Logger/class.' . $urlData['scheme'] . 'LoggerBackend.php';

if (!file_exists($fileName)) {
    throw new Exception("Archivo no encontrado: " . $fileName);
}

include_once($fileName);

$className = $urlData['scheme'] . 'LoggerBackend';

print "Nombre de la clase: " . $className . "\n";

if (!class_exists($className)) {
    throw new Exception("No hay backend de logging disponible para " . $urlData['scheme']);
}

$log = $className::getInstance();

// Guardar tres mensajes en el log
$log->logMessage('Primer mensaje importante para registrar.', $className::DEBUG);
$log->logMessage('Segundo mensaje importante para registrar.', $className::INFO);
$log->logMessage('Tercer mensaje importante para registrar.', $className::ERROR);

print "Logger " . $urlData['scheme'] . " creado. [FIN]\n";
