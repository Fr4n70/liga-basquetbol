<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';
  $id     = intval($_POST['id'] ?? 0);
  $nom    = limpiar($conector, $_POST['nom']    ?? '');
  $ciudad = limpiar($conector, $_POST['ciudad'] ?? '');
  $color  = limpiar($conector, $_POST['color']  ?? '');
  $est    = intval($_POST['est'] ?? 1);
  if ($id <= 0 || empty($nom)) { $errors[] = "Datos inválidos."; }
  elseif ($conector->query("SELECT codEqu FROM equipos WHERE nomEqu='$nom' AND codEqu<>$id")->num_rows > 0) {
    $errors[] = "Nombre ya en uso.";
  } else {
    $sql = "UPDATE equipos SET nomEqu='$nom',ciudadEqu='$ciudad',colorEqu='$color',estEqu=$est WHERE codEqu=$id";
    if ($conector->query($sql)) { $messages[] = "Equipo actualizado."; }
    else { $errors[] = "Error: " . $conector->error; }
  }
  include '_response.php';
?>
