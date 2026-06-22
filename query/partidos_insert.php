<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';

  $local     = intval($_POST['local']     ?? 0);
  $visitante = intval($_POST['visitante'] ?? 0);
  $fecha     = limpiar($conector, $_POST['fecha'] ?? '');
  $hora      = limpiar($conector, $_POST['hora']  ?? '');
  $lugar     = limpiar($conector, $_POST['lugar'] ?? '');
  $reg       = date('Y-m-d H:i:s');

  if ($local <= 0 || $visitante <= 0 || empty($fecha) || empty($hora) || empty($lugar)) {
    $errors[] = "Completa todos los campos.";
  } elseif ($local === $visitante) {
    $errors[] = "El equipo local y visitante no pueden ser el mismo.";
  } else {
    $sql = "INSERT INTO partidos (equLocPar,equVisPar,fechaPar,horaPar,lugarPar,ptsLocPar,ptsVisPar,estPar,regPar)
            VALUES ($local,$visitante,'$fecha','$hora','$lugar',0,0,0,'$reg')";
    if ($conector->query($sql)) {
      $messages[] = "Partido programado correctamente.";
    } else {
      $errors[] = "Error: " . $conector->error;
    }
  }
  include '_response.php';
?>
