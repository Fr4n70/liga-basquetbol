<?php
  function redireccionar($url) {
    if (!headers_sent()) {
      header("Location: $url");
      exit();
    } else {
      echo "<script>window.location.href='$url'</script>";
    }
  }

  function validarDNI($dni) {
    return preg_match('/^\d{8}$/', $dni);
  }

  function validarCel($cel) {
    return preg_match('/^9\d{8}$/', $cel);
  }

  function sesionActiva() {
    session_start();
    if (empty($_SESSION['codUsu'])) {
      redireccionar('./');
    }
  }

  function limpiar($conector, $valor) {
    return $conector->real_escape_string(strip_tags(trim($valor)));
  }
?>
