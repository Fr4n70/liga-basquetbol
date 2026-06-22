<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block">
        <a href="inicio.php" class="nav-link"><i class="bi bi-house"></i> Inicio</a>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <!-- Pantalla completa -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display:none"></i>
        </a>
      </li>
      <!-- Usuario -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="assets/img/avatar.png" class="user-image rounded-circle shadow" alt="<?php echo $user['nomUsu'] ?? ''; ?>">
          <span class="d-none d-md-inline"><?php echo ($user['nomUsu'] ?? '') . ' ' . ($user['apeUsu'] ?? ''); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-bg-warning">
            <img src="assets/img/avatar.png" class="rounded-circle shadow" alt="">
            <p>
              <?php echo ($user['nomUsu'] ?? '') . ' ' . ($user['apeUsu'] ?? ''); ?>
              <small><?php echo ($user['rolUsu'] ?? 1) == 0 ? 'Administrador' : 'Usuario'; ?></small>
            </p>
          </li>
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat"><i class="bi bi-person"></i> Perfil</a>
            <a href="lib/PHP_salir.php" class="btn btn-default btn-flat float-end">
              <i class="bi bi-box-arrow-right"></i> Salir
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
