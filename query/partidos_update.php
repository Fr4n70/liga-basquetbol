<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';

  $id       = intval($_POST['id']            ?? 0);
  $pts_loc  = intval($_POST['pts_local']     ?? 0);
  $pts_vis  = intval($_POST['pts_visitante'] ?? 0);
  $est      = intval($_POST['est']           ?? 0);

  if ($id <= 0) {
    $errors[] = "ID de partido inválido.";
  } elseif ($pts_loc < 0 || $pts_vis < 0) {
    $errors[] = "Los puntos no pueden ser negativos.";
  } else {
    $sql = "UPDATE partidos SET ptsLocPar=$pts_loc, ptsVisPar=$pts_vis, estPar=$est WHERE codPar=$id";
    if ($conector->query($sql)) {
      $messages[] = "Resultado actualizado correctamente.";
    } else {
      $errors[] = "Error: " . $conector->error;
    }
  }
  include '_response.php';
?>
