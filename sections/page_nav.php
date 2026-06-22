<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="inicio.php" class="brand-link">
      <img src="assets/img/logo.png" alt="Logo" class="brand-image opacity-75 shadow">
      <span class="brand-text fw-bold"><?php echo $app['name']; ?></span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="inicio.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=='inicio.php')?'active':''; ?>">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">GESTIÓN</li>

        <li class="nav-item">
          <a href="usuarios.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=='usuarios.php')?'active':''; ?>">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>Usuarios</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="equipos.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=='equipos.php')?'active':''; ?>">
            <i class="nav-icon bi bi-shield-fill"></i>
            <p>Equipos</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="jugadores.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=='jugadores.php')?'active':''; ?>">
            <i class="nav-icon bi bi-person-badge-fill"></i>
            <p>Jugadores</p>
          </a>
        </li>

        <li class="nav-header">COMPETENCIA</li>

        <li class="nav-item">
          <a href="partidos.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=='partidos.php')?'active':''; ?>">
            <i class="nav-icon bi bi-trophy-fill"></i>
            <p>Partidos</p>
          </a>
        </li>

        <li class="nav-header">SISTEMA</li>
        <li class="nav-item">
          <a href="lib/PHP_salir.php" class="nav-link text-danger">
            <i class="nav-icon bi bi-box-arrow-right"></i>
            <p>Cerrar Sesión</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
