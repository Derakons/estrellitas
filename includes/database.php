<?php

// Configuración de la conexión
$servername = "localhost"; 
$username = "root";      // Usuario por defecto de XAMPP
$password = "";          // Contraseña por defecto de XAMPP
$dbname = "astroshop";   // Nombre de tu base de datos

// Crear conexión usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Configuración para caracteres especiales (UTF-8)
$conn->set_charset("utf8");

// Función para ejecutar consultas preparadas
function ejecutarConsulta($sql, $tipos = null, ...$params) {
  global $conn;

  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
  }

  if ($tipos && $params) {
    $stmt->bind_param($tipos, ...$params);
  }

  if ($stmt->execute()) {
    if ($stmt->result_metadata()) {
      return $stmt->get_result();
    } else {
      return true;
    }
  } else {
    die("Error al ejecutar la consulta: " . $stmt->error);
  }

  $stmt->close();
}

?>