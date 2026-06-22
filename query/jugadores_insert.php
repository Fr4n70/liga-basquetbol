<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';
  if (empty($_POST['equipo'])||empty($_POST['nom'])||empty($_POST['app'])||empty($_POST['dni'])||empty($_POST['pos'])||empty($_POST['num'])) {
    $errors[] = "Completa los campos obligatorios.";
  } else {
    $equ = intval($_POST['equipo']);
    $nom = limpiar($conector, $_POST['nom']);
    $app = limpiar($conector, $_POST['app']);
    $dni = limpiar($conector, $_POST['dni']);
    $cel = limpiar($conector, $_POST['cel'] ?? '');
    $fn  = $_POST['fn'] ?? null;
    $pos = limpiar($conector, $_POST['pos']);
    $num = intval($_POST['num']);
    $reg = date('Y-m-d H:i:s');
    if (!validarDNI($dni)) { $errors[] = "DNI inválido."; }
    elseif ($conector->query("SELECT codJug FROM jugadores WHERE dniJug='$dni'")->num_rows > 0) { $errors[] = "El DNI ya existe."; }
    elseif ($conector->query("SELECT codJug FROM jugadores WHERE numJug=$num AND codEqu=$equ AND estJug=1")->num_rows > 0) { $errors[] = "Número de camiseta ya en uso en este equipo."; }
    else {
      $fn_val = $fn ? "'$fn'" : 'NULL';
      $sql = "INSERT INTO jugadores (codEqu,dniJug,nomJug,apeJug,posJug,numJug,celJug,fnaJug,estJug,regJug)
              VALUES ($equ,'$dni','$nom','$app','$pos',$num,'$cel',$fn_val,1,'$reg')";
      if ($conector->query($sql)) { $messages[] = "Jugador registrado exitosamente."; }
      else { $errors[] = "Error: " . $conector->error; }
    }
  }
  include '_response.php';
?>
