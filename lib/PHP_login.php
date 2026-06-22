<?php
  @session_start();
  include_once '../config/conexion.php';
  include_once '../config/datos.php';

  if (empty($_POST['email']) || empty($_POST['pass'])) {
    $errors[] = "Completa todos los campos.";
  } else {
    $email = $conector->real_escape_string(trim($_POST['email']));
    $pass  = trim($_POST['pass']);

    $sql   = "SELECT * FROM usuarios WHERE emaUsu='$email'";
    $query = $conector->query($sql);

    if ($query->num_rows > 0) {
      $row = $query->fetch_assoc();
      if (password_verify($pass, $row['pasUsu'])) {
        if ($row['estUsu'] == 0) {
          $errors[] = "Tu cuenta está bloqueada.";
        } else {
          $_SESSION['codUsu'] = $row['codUsu'];
          $messages[] = "Bienvenido, " . $row['nomUsu'] . "!";
          echo json_encode(['status'=>'ok','msg'=>$messages[0]]);
          exit;
        }
      } else {
        $errors[] = "Contraseña incorrecta.";
      }
    } else {
      $errors[] = "El correo no está registrado.";
    }
  }

  if (isset($errors)) {
    echo json_encode(['status'=>'error','msg'=>implode(' ', $errors)]);
  }
?>
