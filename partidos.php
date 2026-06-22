<?php
  @session_start();
  include_once 'config/datos.php';
  include_once 'config/conexion.php';
  include_once 'config/funciones.php';
  if (empty($_SESSION['codUsu'])) { redireccionar('./'); }
  $id_user = $_SESSION['codUsu'];
  $user  = $conector->query("SELECT * FROM usuarios WHERE codUsu='$id_user'")->fetch_assoc();
  $title = "Partidos";
  $equipos = $conector->query("SELECT codEqu,nomEqu FROM equipos WHERE estEqu=1 ORDER BY nomEqu");
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?> | <?php echo $app['name']; ?></title>
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
          <div class="col-sm-6"><h3 class="mb-0"><i class="bi bi-trophy-fill"></i> <?php echo $title; ?></h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
              <li class="breadcrumb-item active">Partidos</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-warning card-outline mb-4">
          <div class="card-header d-flex align-items-center">
            <h5 class="card-title m-0">Calendario de Partidos</h5>
            <button class="btn btn-warning ms-auto" data-bs-toggle="modal" data-bs-target="#modalRegPar">
              <i class="bi bi-plus-circle-fill"></i> Programar Partido
            </button>
          </div>
          <div class="card-body">
            <div class="text-center" id="loader_par"><i class="bi bi-hourglass-split fs-3 text-muted"></i></div>
            <div class="div_partidos"></div>
          </div>
        </div>

        <!-- Modal Registrar -->
        <div class="modal fade" id="modalRegPar" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-trophy"></i> Programar Partido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_insert_par">
              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-house-fill"></i> Equipo Local</label>
                    <select name="local" class="form-select" required>
                      <option value="">-- Seleccione --</option>
                      <?php $equipos->data_seek(0); while($e=$equipos->fetch_assoc()): ?>
                      <option value="<?php echo $e['codEqu']; ?>"><?php echo $e['nomEqu']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-airplane-fill"></i> Equipo Visitante</label>
                    <select name="visitante" class="form-select" required>
                      <option value="">-- Seleccione --</option>
                      <?php $equipos->data_seek(0); while($e=$equipos->fetch_assoc()): ?>
                      <option value="<?php echo $e['codEqu']; ?>"><?php echo $e['nomEqu']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="col-md-4"><label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">Lugar / Coliseo</label>
                    <input type="text" name="lugar" class="form-control" required></div>
                </div>
                <div class="mt-2" id="resp_ins_par"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Programar</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal Resultado -->
        <div class="modal fade" id="modalResultado" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="titResultado"><i class="bi bi-check2-square"></i> Registrar Resultado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_resultado">
              <div class="modal-body">
                <input type="hidden" name="id" id="res_id">
                <div class="row g-3 text-center">
                  <div class="col-5">
                    <label class="form-label fw-bold" id="res_local_nom">Local</label>
                    <input type="number" name="pts_local" id="res_pts_loc" class="form-control form-control-lg text-center fw-bold" min="0" required>
                  </div>
                  <div class="col-2 d-flex align-items-center justify-content-center">
                    <span class="fs-3 fw-bold text-muted">VS</span>
                  </div>
                  <div class="col-5">
                    <label class="form-label fw-bold" id="res_vis_nom">Visitante</label>
                    <input type="number" name="pts_visitante" id="res_pts_vis" class="form-control form-control-lg text-center fw-bold" min="0" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Estado del Partido</label>
                    <select name="est" id="res_est" class="form-select">
                      <option value="1">En Juego</option>
                      <option value="2">Finalizado</option>
                    </select>
                  </div>
                </div>
                <div class="mt-2" id="resp_resultado"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Resultado</button>
              </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
  <?php include_once 'sections/page_footer.php'; ?>
</div>
<?php include_once 'sections/page_script.php'; ?>
<script src="lib/partidos.js?v=1"></script>
<script>$(document).ready(function(){ cargarPartidos(); });</script>
</body>
</html>
