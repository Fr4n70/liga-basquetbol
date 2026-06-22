<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';
  $id  = intval($_POST['id'] ?? 0);
  $equ = intval($_POST['equipo'] ?? 0);
  $nom = limpiar($conector, $_POST['nom'] ?? '');
  $app = limpiar($conector, $_POST['app'] ?? '');
  $dni = limpiar($conector, $_POST['dni'] ?? '');
  $cel = limpiar($conector, $_POST['cel'] ?? '');
  $fn  = $_POST['fn'] ?? null;
  $pos = limpiar($conector, $_POST['pos'] ?? '');
  $num = intval($_POST['num'] ?? 0);
  $est = intval($_POST['est'] ?? 1);
  if ($id<=0) { $errors[] = "ID inválido."; }
  elseif (!validarDNI($dni)) { $errors[] = "DNI inválido."; }
  elseif ($conector->query("SELECT codJug FROM jugadores WHERE dniJug='$dni' AND codJug<>$id")->num_rows > 0) { $errors[] = "DNI ya en uso."; }
  elseif ($conector->query("SELECT codJug FROM jugadores WHERE numJug=$num AND codEqu=$equ AND codJug<>$id AND estJug=1")->num_rows > 0) { $errors[] = "N° camiseta en uso."; }
  else {
    $fn_val = $fn ? "'$fn'" : 'NULL';
    $sql = "UPDATE jugadores SET codEqu=$equ,dniJug='$dni',nomJug='$nom',apeJug='$app',posJug='$pos',numJug=$num,celJug='$cel',fnaJug=$fn_val,estJug=$est WHERE codJug=$id";
    if ($conector->query($sql)) { $messages[] = "Jugador actualizado."; }
    else { $errors[] = "Error: " . $conector->error; }
  }
  include '_response.php';
?>
