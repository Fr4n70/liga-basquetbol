<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';

  $campos = ['nom','app','dni','fn','cel','sex','email'];
  foreach ($campos as $c) {
    if (empty($_POST[$c])) { $errors[] = "Completa todos los campos."; break; }
  }

  if (!isset($errors)) {
    $nom   = limpiar($conector, $_POST['nom']);
    $app   = limpiar($conector, $_POST['app']);
    $dni   = limpiar($conector, $_POST['dni']);
    $cel   = limpiar($conector, $_POST['cel']);
    $email = limpiar($conector, $_POST['email']);
    $fn    = $_POST['fn'];
    $sex   = $_POST['sex'] == 'M' ? 1 : 0;
    $rol   = intval($_POST['rol'] ?? 1);
    $reg   = date('Y-m-d H:i:s');
    $pass  = password_hash($dni, PASSWORD_DEFAULT); // contraseña inicial = DNI

    if (!validarDNI($dni)) {
      $errors[] = "DNI inválido (8 dígitos).";
    } elseif (!validarCel($cel)) {
      $errors[] = "Celular inválido (9 dígitos, inicia en 9).";
    } elseif ($conector->query("SELECT codUsu FROM usuarios WHERE dniUsu='$dni'")->num_rows > 0) {
      $errors[] = "El DNI ya existe.";
    } elseif ($conector->query("SELECT codUsu FROM usuarios WHERE emaUsu='$email'")->num_rows > 0) {
      $errors[] = "El correo ya existe.";
    } else {
      $sql = "INSERT INTO usuarios (dniUsu,nomUsu,apeUsu,celUsu,fnaUsu,sexUsu,emaUsu,pasUsu,rolUsu,estUsu,regUsu)
              VALUES ('$dni','$nom','$app','$cel','$fn','$sex','$email','$pass','$rol',1,'$reg')";
      if ($conector->query($sql)) {
        $messages[] = "Usuario registrado. Contraseña inicial: DNI del usuario.";
      } else {
        $errors[] = "Error al registrar: " . $conector->error;
      }
    }
  }
  include '_response.php';
?>
