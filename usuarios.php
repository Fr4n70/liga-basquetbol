<?php
  @session_start();
  include_once 'config/datos.php';
  include_once 'config/conexion.php';
  include_once 'config/funciones.php';
  if (empty($_SESSION['codUsu'])) { redireccionar('./'); }
  $id_user = $_SESSION['codUsu'];
  $user = $conector->query("SELECT * FROM usuarios WHERE codUsu='$id_user'")->fetch_assoc();
  $title = "Usuarios del Sistema";
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
          <div class="col-sm-6"><h3 class="mb-0"><i class="bi bi-people-fill"></i> <?php echo $title; ?></h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-warning card-outline mb-4">
          <div class="card-header d-flex align-items-center">
            <h5 class="card-title m-0">Relación de Usuarios</h5>
            <button class="btn btn-warning ms-auto" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
              <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
            </button>
          </div>
          <div class="card-body">
            <div class="text-center" id="loader_usu"><i class="bi bi-hourglass-split fs-3 text-muted"></i></div>
            <div class="div_usuarios"></div>
          </div>
        </div>

        <!-- Modal Registrar -->
        <div class="modal fade" id="modalRegistrar" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Registrar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_insert_usu">
              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-md-6"><label class="form-label">Nombres</label>
                    <input type="text" name="nom" class="form-control" required></div>
                  <div class="col-md-6"><label class="form-label">Apellidos</label>
                    <input type="text" name="app" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" maxlength="8" required></div>
                  <div class="col-md-4"><label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fn" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">Celular</label>
                    <input type="text" name="cel" class="form-control" maxlength="9" required></div>
                  <div class="col-md-6"><label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" required></div>
                  <div class="col-md-3"><label class="form-label">Género</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="sex" value="M" id="ins_M">
                      <label class="form-check-label" for="ins_M">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="sex" value="F" id="ins_F">
                      <label class="form-check-label" for="ins_F">Femenino</label>
                    </div>
                  </div>
                  <div class="col-md-3"><label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                      <option value="0">Administrador</option>
                      <option value="1" selected>Usuario</option>
                    </select>
                  </div>
                </div>
                <div class="mt-2" id="resp_ins_usu"></div>
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
        <div class="modal fade" id="modalEditar" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tituloEditar"><i class="bi bi-pencil-square"></i> Editar Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <form id="form_update_usu">
              <div class="modal-body">
                <input type="hidden" name="id" id="upd_id">
                <div class="row g-3">
                  <div class="col-md-6"><label class="form-label">Nombres</label>
                    <input type="text" name="nom" id="upd_nom" class="form-control" required></div>
                  <div class="col-md-6"><label class="form-label">Apellidos</label>
                    <input type="text" name="app" id="upd_app" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">DNI</label>
                    <input type="text" name="dni" id="upd_dni" class="form-control" maxlength="8" required></div>
                  <div class="col-md-4"><label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fn" id="upd_fn" class="form-control" required></div>
                  <div class="col-md-4"><label class="form-label">Celular</label>
                    <input type="text" name="cel" id="upd_cel" class="form-control" maxlength="9" required></div>
                  <div class="col-md-6"><label class="form-label">Correo</label>
                    <input type="email" name="email" id="upd_email" class="form-control" required></div>
                  <div class="col-md-3"><label class="form-label">Género</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="sex" value="M" id="upd_M">
                      <label class="form-check-label" for="upd_M">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="sex" value="F" id="upd_F">
                      <label class="form-check-label" for="upd_F">Femenino</label>
                    </div>
                  </div>
                  <div class="col-md-3"><label class="form-label">Estado</label>
                    <select name="est" id="upd_est" class="form-select">
                      <option value="1">Activo</option>
                      <option value="0">Bloqueado</option>
                    </select>
                  </div>
                </div>
                <div class="mt-2" id="resp_upd_usu"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
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
<script src="lib/usuarios.js?v=1"></script>
<script>$(document).ready(function(){ cargarUsuarios(); });</script>
</body>
</html>
