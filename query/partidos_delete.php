<?php
  include_once '../config/conexion.php';
  $id = intval($_POST['id'] ?? 0);
  if ($id > 0) {
    $conector->query("DELETE FROM partidos WHERE codPar=$id");
    echo json_encode(['ok' => true]);
  } else {
    echo json_encode(['ok' => false]);
  }
?>
