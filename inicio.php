<?php
  @session_start();
  include_once 'config/datos.php';
  include_once 'config/conexion.php';
  include_once 'config/funciones.php';

  if (empty($_SESSION['codUsu'])) { redireccionar('./'); }

  $id_user = $_SESSION['codUsu'];
  $user = [];
  $res = $conector->query("SELECT * FROM usuarios WHERE codUsu='$id_user'");
  while ($row = $res->fetch_assoc()) { $user = $row; }

  // Estadísticas generales
  $tot_equipos  = $conector->query("SELECT COUNT(*) as t FROM equipos WHERE estEqu=1")->fetch_assoc()['t'];
  $tot_jugadores = $conector->query("SELECT COUNT(*) as t FROM jugadores WHERE estJug=1")->fetch_assoc()['t'];
  $tot_partidos  = $conector->query("SELECT COUNT(*) as t FROM partidos")->fetch_assoc()['t'];
  $tot_finalizados = $conector->query("SELECT COUNT(*) as t FROM partidos WHERE estPar=2")->fetch_assoc()['t'];

  // Próximos partidos
  $prox = $conector->query("
    SELECT p.*, e1.nomEqu AS local, e2.nomEqu AS visitante
    FROM partidos p
    JOIN equipos e1 ON p.equLocPar = e1.codEqu
    JOIN equipos e2 ON p.equVisPar = e2.codEqu
    WHERE p.estPar=0
    ORDER BY p.fechaPar ASC, p.horaPar ASC
    LIMIT 5
  ");

  // Últimos resultados
  $ultimos = $conector->query("
    SELECT p.*, e1.nomEqu AS local, e2.nomEqu AS visitante
    FROM partidos p
    JOIN equipos e1 ON p.equLocPar = e1.codEqu
    JOIN equipos e2 ON p.equVisPar = e2.codEqu
    WHERE p.estPar=2
    ORDER BY p.fechaPar DESC
    LIMIT 5
  ");

  // Tabla de posiciones con puntos acumulados
  $posiciones = $conector->query("
    SELECT e.nomEqu,
      SUM(CASE WHEN (p.equLocPar=e.codEqu AND p.ptsLocPar>p.ptsVisPar AND p.estPar=2) OR
                    (p.equVisPar=e.codEqu AND p.ptsVisPar>p.ptsLocPar AND p.estPar=2) THEN 1 ELSE 0 END) AS victorias,
      SUM(CASE WHEN (p.equLocPar=e.codEqu AND p.ptsLocPar<p.ptsVisPar AND p.estPar=2) OR
                    (p.equVisPar=e.codEqu AND p.ptsVisPar<p.ptsLocPar AND p.estPar=2) THEN 1 ELSE 0 END) AS derrotas,
      COUNT(CASE WHEN (p.equLocPar=e.codEqu OR p.equVisPar=e.codEqu) AND p.estPar=2 THEN 1 END) AS jugados,
      SUM(CASE WHEN (p.equLocPar=e.codEqu AND p.ptsLocPar>p.ptsVisPar AND p.estPar=2) OR
                    (p.equVisPar=e.codEqu AND p.ptsVisPar>p.ptsLocPar AND p.estPar=2) THEN 2 ELSE 0 END) AS puntos
    FROM equipos e
    LEFT JOIN partidos p ON (p.equLocPar=e.codEqu OR p.equVisPar=e.codEqu)
    WHERE e.estEqu=1
    GROUP BY e.codEqu, e.nomEqu
    ORDER BY puntos DESC, victorias DESC, derrotas ASC, e.nomEqu ASC
  ");
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Dashboard | <?php echo $app['name']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include_once 'sections/page_css.php'; ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
  <?php include_once 'sections/page_header.php'; ?>
  <?php include_once 'sections/page_nav.php'; ?>

  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item active">Inicio</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
          <div class="col-lg-3 col-6 mb-3">
            <div class="card stat-card naranja shadow-sm">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <div class="text-muted small">Equipos Activos</div>
                  <div class="h3 fw-bold mb-0"><?php echo $tot_equipos; ?></div>
                </div>
                <i class="bi bi-shield-fill fs-1 text-warning opacity-50"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6 mb-3">
            <div class="card stat-card azul shadow-sm">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <div class="text-muted small">Jugadores</div>
                  <div class="h3 fw-bold mb-0"><?php echo $tot_jugadores; ?></div>
                </div>
                <i class="bi bi-person-badge-fill fs-1 text-primary opacity-50"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6 mb-3">
            <div class="card stat-card verde shadow-sm">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <div class="text-muted small">Total Partidos</div>
                  <div class="h3 fw-bold mb-0"><?php echo $tot_partidos; ?></div>
                </div>
                <i class="bi bi-trophy-fill fs-1 text-success opacity-50"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6 mb-3">
            <div class="card stat-card rojo shadow-sm">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <div class="text-muted small">Partidos Jugados</div>
                  <div class="h3 fw-bold mb-0"><?php echo $tot_finalizados; ?></div>
                </div>
                <i class="bi bi-check-circle-fill fs-1 text-danger opacity-50"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- Próximos partidos -->
          <div class="col-lg-5 mb-4">
            <div class="card card-warning card-outline">
              <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-calendar-event"></i> Próximos Partidos</h5>
              </div>
              <div class="card-body p-0">
                <?php if ($prox->num_rows > 0): ?>
                <ul class="list-group list-group-flush">
                  <?php while ($p = $prox->fetch_assoc()): ?>
                  <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <strong><?php echo $p['local']; ?></strong>
                        <span class="badge bg-secondary mx-1">VS</span>
                        <strong><?php echo $p['visitante']; ?></strong>
                        <br>
                        <small class="text-muted">
                          <i class="bi bi-calendar3"></i> <?php echo date('d/m/Y', strtotime($p['fechaPar'])); ?>
                          &nbsp;<i class="bi bi-clock"></i> <?php echo substr($p['horaPar'],0,5); ?>
                        </small>
                      </div>
                      <span class="badge bg-secondary">Programado</span>
                    </div>
                  </li>
                  <?php endwhile; ?>
                </ul>
                <?php else: ?>
                <div class="p-3 text-center text-muted">No hay partidos programados.</div>
                <?php endif; ?>
              </div>
              <div class="card-footer text-end">
                <a href="partidos.php" class="btn btn-sm btn-warning">Ver todos <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <!-- Tabla de posiciones -->
          <div class="col-lg-4 mb-4">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-bar-chart-fill"></i> Tabla de Posiciones</h5>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Equipo</th>
                      <th class="text-center">J</th>
                      <th class="text-center">V</th>
                      <th class="text-center">D</th>
                      <th class="text-center">Puntos</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $pos=1; while ($p = $posiciones->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo $pos++; ?></td>
                      <td><?php echo $p['nomEqu']; ?></td>
                      <td class="text-center"><?php echo $p['jugados']; ?></td>
                      <td class="text-center fw-bold text-success"><?php echo $p['victorias']; ?></td>
                      <td class="text-center text-danger"><?php echo $p['derrotas']; ?></td>
                      <td class="text-center fw-bold text-primary"><?php echo $p['puntos']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Últimos resultados -->
          <div class="col-lg-3 mb-4">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-check2-circle"></i> Últimos Resultados</h5>
              </div>
              <div class="card-body p-0">
                <?php if ($ultimos->num_rows > 0): ?>
                <ul class="list-group list-group-flush">
                  <?php while ($p = $ultimos->fetch_assoc()): ?>
                  <li class="list-group-item py-2">
                    <div class="text-center">
                      <small class="text-muted"><?php echo date('d/m/Y', strtotime($p['fechaPar'])); ?></small><br>
                      <strong class="<?php echo $p['ptsLocPar']>$p['ptsVisPar']?'text-success':'text-danger'; ?>"><?php echo $p['local']; ?></strong>
                      <span class="fw-bold mx-1"><?php echo $p['ptsLocPar']; ?> - <?php echo $p['ptsVisPar']; ?></span>
                      <strong class="<?php echo $p['ptsVisPar']>$p['ptsLocPar']?'text-success':'text-danger'; ?>"><?php echo $p['visitante']; ?></strong>
                    </div>
                  </li>
                  <?php endwhile; ?>
                </ul>
                <?php else: ?>
                <div class="p-3 text-center text-muted">Sin resultados aún.</div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <?php include_once 'sections/page_footer.php'; ?>
</div>
<?php include_once 'sections/page_script.php'; ?>
</body>
</html>