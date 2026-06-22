<?php
  include_once 'bd.php';
  $conector = new mysqli($servidor, $usuario, $password, $bd);
  $conector->set_charset("utf8mb4");
  if ($conector->connect_error) {
    die('Error de Conexión: ' . $conector->connect_error);
  }
?>
