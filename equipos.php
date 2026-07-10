<?php
  @session_start();
  include_once 'config/datos.php';
  include_once 'config/conexion.php';
  include_once 'config/funciones.php';
  if (empty($_SESSION['codUsu'])) { redireccionar('./'); }
  $id_user = $_SESSION['codUsu'];
  $user  = $conector->query("SELECT * FROM usuarios WHERE codUsu='$id_user'")->fetch_assoc();
  $title = "Equipos";
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
          <div class="col-sm-6"><h3 class="mb-0"><i class="bi bi-shield-fill"></i> <?php echo $title; ?></h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
              <li class="breadcrumb-item active">Equipos</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-warning card-outline mb-4">
          <div class="card-header d-flex align-items-center">
            <h5 class="card-title m-0">Relación de Equipos</h5>
            <button class="btn btn-warning ms-auto" data-bs-toggle="modal" data-bs-target="#modalRegEqu">
              <i class="bi bi-plus-circle-fill"></i> Nuevo Equipo
            </button>
          </div>
          <div class="card-body">
            <div class="text-center" id="loader_equ"><i class="bi bi-hourglass-split fs-3 text-muted"></i></div>
            <div class="div_equipos"></div>
          </div>
        </div>

        <!-- Modal Registrar -->
        <div class="modal fade" id="modalRegEqu" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-shield-plus"></i> Registrar Equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_insert_equ">
              <div class="modal-body">
                <div class="mb-3"><label class="form-label">Nombre del Equipo</label>
                  <input type="text" name="nom" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Ciudad</label>
                  <input type="text" name="ciudad" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Colores del Equipo</label>
                  <input type="text" name="color" class="form-control" placeholder="Ej: Rojo y Blanco"></div>
                <div id="resp_ins_equ"></div>
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
        <div class="modal fade" id="modalEditEqu" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="titEditEqu"><i class="bi bi-pencil-square"></i> Editar Equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_update_equ">
              <div class="modal-body">
                <input type="hidden" name="id" id="ueq_id">
                <div class="mb-3"><label class="form-label">Nombre del Equipo</label>
                  <input type="text" name="nom" id="ueq_nom" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Ciudad</label>
                  <input type="text" name="ciudad" id="ueq_ciudad" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Colores</label>
                  <input type="text" name="color" id="ueq_color" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Estado</label>
                  <select name="est" id="ueq_est" class="form-select">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                </div>
                <div id="resp_upd_equ"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal HU-03 Perfil Equipo -->
        <div class="modal fade" id="modalPerfilEqu" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-shield-fill"></i> Perfil del Equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body" id="contenido_perfil_equ">
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
<script src="lib/equipos.js?v=1"></script>
<script>
$(document).ready(function(){ cargarEquipos(); });

$(document).on('click', '.btn-perfil-equ', function() {
  var id = $(this).data('id');
  $('#contenido_perfil_equ').html('<div class="text-center"><i class="bi bi-hourglass-split fs-3 text-muted"></i> Cargando...</div>');
  $('#modalPerfilEqu').modal('show');
  $.ajax({
    url: 'query/equipo_perfil.php',
    data: { id: id },
    success: function(data) {
      $('#contenido_perfil_equ').html(data);
    }
  });
});
</script>
</body>
</html>