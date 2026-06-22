<?php
  include_once '../config/conexion.php';
  $id = intval($_POST['id'] ?? 0);
  if ($id > 0) {
    $conector->query("DELETE FROM jugadores WHERE codEqu=$id");
    $conector->query("DELETE FROM equipos WHERE codEqu=$id");
    echo json_encode(['ok'=>true]);
  }
?>
