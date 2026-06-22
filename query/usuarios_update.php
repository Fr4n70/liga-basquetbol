<?php
  include_once '../config/conexion.php';
  include_once '../config/funciones.php';

  if (empty($_POST['id'])) { $errors[] = "ID inválido."; }
  else {
    $id    = intval($_POST['id']);
    $nom   = limpiar($conector, $_POST['nom']   ?? '');
    $app   = limpiar($conector, $_POST['app']   ?? '');
    $dni   = limpiar($conector, $_POST['dni']   ?? '');
    $cel   = limpiar($conector, $_POST['cel']   ?? '');
    $email = limpiar($conector, $_POST['email'] ?? '');
    $fn    = $_POST['fn'] ?? '';
    $sex   = ($_POST['sex'] ?? 'M') == 'M' ? 1 : 0;
    $est   = intval($_POST['est'] ?? 1);

    if (!validarDNI($dni)) {
      $errors[] = "DNI inválido.";
    } elseif (!validarCel($cel)) {
      $errors[] = "Celular inválido.";
    } elseif ($conector->query("SELECT codUsu FROM usuarios WHERE dniUsu='$dni' AND codUsu<>$id")->num_rows > 0) {
      $errors[] = "El DNI ya pertenece a otro usuario.";
    } elseif ($conector->query("SELECT codUsu FROM usuarios WHERE emaUsu='$email' AND codUsu<>$id")->num_rows > 0) {
      $errors[] = "El correo ya pertenece a otro usuario.";
    } else {
      $sql = "UPDATE usuarios SET nomUsu='$nom',apeUsu='$app',dniUsu='$dni',celUsu='$cel',
              fnaUsu='$fn',sexUsu='$sex',emaUsu='$email',estUsu='$est' WHERE codUsu=$id";
      if ($conector->query($sql)) {
        $messages[] = "Usuario actualizado correctamente.";
      } else {
        $errors[] = "Error: " . $conector->error;
      }
    }
  }
  include '_response.php';
?>
