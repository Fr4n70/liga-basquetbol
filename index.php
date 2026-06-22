<?php
  @session_start();
  include_once 'config/datos.php';
  include_once 'config/funciones.php';
  if (!empty($_SESSION['codUsu'])) {
    redireccionar('inicio.php');
  }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Iniciar Sesión | <?php echo $app['name']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include_once 'sections/page_css.php'; ?>
</head>
<body class="login-page bg-body-secondary">
  <div class="login-box">
    <div class="card card-outline card-warning">
      <div class="card-header text-center">
        <img src="assets/img/logo.png" alt="Logo" height="60" class="mb-2"><br>
        <a href="./" class="h3 fw-bold text-dark"><?php echo $app['name']; ?></a>
        <p class="text-muted small mt-1">Sistema de Gestión de Liga</p>
      </div>
      <div class="card-body login-card-body">
        <p class="login-box-msg">Inicia sesión para continuar</p>
        <form id="frm_login">
          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input id="loginEmail" type="email" class="form-control" name="email" placeholder="Email">
              <label for="loginEmail"><i class="bi bi-envelope"></i> Correo electrónico</label>
            </div>
            <div class="input-group-text"><i class="bi bi-envelope-fill"></i></div>
          </div>
          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input id="loginPassword" type="password" class="form-control" name="pass" placeholder="Contraseña">
              <label for="loginPassword"><i class="bi bi-lock"></i> Contraseña</label>
            </div>
            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
          </div>
          <div class="row mb-2">
            <div class="col-8 d-flex align-items-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-warning w-100 fw-bold">
                <i class="bi bi-box-arrow-in-right"></i> Acceder
              </button>
            </div>
          </div>
          <div id="resp_login" class="mt-2"></div>
        </form>
      </div>
    </div>
  </div>

  <?php include_once 'sections/page_script.php'; ?>
  <script src="lib/login.js"></script>
</body>
</html>
