<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';
  if (empty($_POST['nom']) || empty($_POST['ciudad'])) {
    $errors[] = "Nombre y ciudad son obligatorios.";
  } else {
    $nom    = limpiar($conector, $_POST['nom']);
    $ciudad = limpiar($conector, $_POST['ciudad']);
    $color  = limpiar($conector, $_POST['color'] ?? '');
    $reg    = date('Y-m-d H:i:s');
    if ($conector->query("SELECT codEqu FROM equipos WHERE nomEqu='$nom'")->num_rows > 0) {
      $errors[] = "Ya existe un equipo con ese nombre.";
    } else {
      $sql = "INSERT INTO equipos (nomEqu,ciudadEqu,colorEqu,estEqu,regEqu) VALUES ('$nom','$ciudad','$color',1,'$reg')";
      if ($conector->query($sql)) { $messages[] = "Equipo registrado exitosamente."; }
      else { $errors[] = "Error: " . $conector->error; }
    }
  }
  include '_response.php';
?>
