<?php
  @session_start();
  session_unset();
  session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cerrando sesión...</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
  <script>
    Swal.fire({
      title: '¡Hasta pronto!',
      text: 'Sesión cerrada correctamente.',
      icon: 'success',
      timer: 2000,
      showConfirmButton: false
    }).then(function() {
      window.location.href = '../';
    });
  </script>
</body>
</html>
