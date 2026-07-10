<?php
  @session_start();
  include_once 'config/datos.php';
  include_once 'config/conexion.php';
  include_once 'config/funciones.php';
  if (empty($_SESSION['codUsu'])) { redireccionar('./'); }
  $id_user = $_SESSION['codUsu'];
  $user  = $conector->query("SELECT * FROM usuarios WHERE codUsu='$id_user'")->fetch_assoc();
  $title = "Jugadores";
  $equipos = $conector->query("SELECT codEqu, nomEqu FROM equipos WHERE estEqu=1 ORDER BY nomEqu");
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
          <div class="col-sm-6"><h3 class="mb-0"><i class="bi bi-person-badge-fill"></i> <?php echo $title; ?></h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
              <li class="breadcrumb-item active">Jugadores</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-warning card-outline mb-4">
          <div class="card-header d-flex align-items-center">
            <h5 class="card-title m-0">Relación de Jugadores</h5>
            <button class="btn btn-warning ms-auto" data-bs-toggle="modal" data-bs-target="#modalRegJug">
              <i class="bi bi-person-plus-fill"></i> Nuevo Jugador
            </button>
          </div>
          <div class="card-body">
            <div class="text-center" id="loader_jug"><i class="bi bi-hourglass-split fs-3 text-muted"></i></div>
            <div class="div_jugadores"></div>
          </div>
        </div>

        <!-- Modal Registrar -->
        <div class="modal fade" id="modalRegJug" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Registrar Jugador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_insert_jug">
              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-md-12">
                    <label class="form-label">Equipo</label>
                    <select name="equipo" class="form-select" required>
                      <option value="">-- Seleccione --</option>
                      <?php $equipos->data_seek(0); while($e=$equipos->fetch_assoc()): ?>
                      <option value="<?php echo $e['codEqu']; ?>"><?php echo $e['nomEqu']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="col-md-6"><label class="form-label">Nombres</label>
                    <input type="text" name="nom" class="form-control" required></div>
                  <div class="col-md-6"><label class="form-label">Apellidos</label>
                    <input type="text" name="app" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" maxlength="8" required></div>
                  <div class="col-md-4"><label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fn" class="form-control"></div>
                  <div class="col-md-4"><label class="form-label">Celular</label>
                    <input type="text" name="cel" class="form-control" maxlength="9"></div>
                  <div class="col-md-6"><label class="form-label">Posición</label>
                    <select name="pos" class="form-select" required>
                      <option value="">-- Seleccione --</option>
                      <option>Base</option><option>Escolta</option><option>Alero</option>
                      <option>Ala-Pívot</option><option>Pívot</option>
                    </select>
                  </div>
                  <div class="col-md-6"><label class="form-label">Número de Camiseta</label>
                    <input type="number" name="num" class="form-control" min="0" max="99" required></div>
                </div>
                <div class="mt-2" id="resp_ins_jug"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Guardar</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="modalEditJug" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="titEditJug"><i class="bi bi-pencil-square"></i> Editar Jugador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_update_jug">
              <div class="modal-body">
                <input type="hidden" name="id" id="ujg_id">
                <div class="row g-3">
                  <div class="col-md-12">
                    <label class="form-label">Equipo</label>
                    <select name="equipo" id="ujg_equipo" class="form-select" required>
                      <?php $equipos->data_seek(0); while($e=$equipos->fetch_assoc()): ?>
                      <option value="<?php echo $e['codEqu']; ?>"><?php echo $e['nomEqu']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="col-md-6"><label class="form-label">Nombres</label>
                    <input type="text" name="nom" id="ujg_nom" class="form-control" required></div>
                  <div class="col-md-6"><label class="form-label">Apellidos</label>
                    <input type="text" name="app" id="ujg_app" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">DNI</label>
                    <input type="text" name="dni" id="ujg_dni" class="form-control" maxlength="8" required></div>
                  <div class="col-md-4"><label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fn" id="ujg_fn" class="form-control"></div>
                  <div class="col-md-4"><label class="form-label">Celular</label>
                    <input type="text" name="cel" id="ujg_cel" class="form-control" maxlength="9"></div>
                  <div class="col-md-6"><label class="form-label">Posición</label>
                    <select name="pos" id="ujg_pos" class="form-select" required>
                      <option>Base</option><option>Escolta</option><option>Alero</option>
                      <option>Ala-Pívot</option><option>Pívot</option>
                    </select>
                  </div>
                  <div class="col-md-3"><label class="form-label">N° Camiseta</label>
                    <input type="number" name="num" id="ujg_num" class="form-control" min="0" max="99"></div>
                  <div class="col-md-3"><label class="form-label">Estado</label>
                    <select name="est" id="ujg_est" class="form-select">
                      <option value="1">Activo</option><option value="0">Inactivo</option>
                    </select>
                  </div>
                </div>
                <div class="mt-2" id="resp_upd_jug"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal HU-04 Stats Jugador -->
        <div class="modal fade" id="modalStatsJug" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-bar-chart-fill"></i> Estadísticas del Jugador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body" id="contenido_stats_jug">
                <div class="text-center"><i class="bi bi-hourglass-split fs-3 text-muted"></i> Cargando...</div>
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
<script src="lib/jugadores.js?v=1"></script>
<script>
$(document).ready(function(){ cargarJugadores(); });

$(document).on('click', '.btn-stats-jug', function() {
  var id = $(this).data('id');
  $('#contenido_stats_jug').html('<div class="text-center"><i class="bi bi-hourglass-split fs-3 text-muted"></i> Cargando...</div>');
  $('#modalStatsJug').modal('show');
  $.ajax({
    url: 'query/jugador_stats.php',
    data: { id: id },
    success: function(data) {
      $('#contenido_stats_jug').html(data);
    }
  });
});
</script>
</body>
</html>