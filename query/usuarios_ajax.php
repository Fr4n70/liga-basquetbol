<?php
  @session_start();
  include_once '../config/conexion.php';

  $action = $_REQUEST['action'] ?? '';
  if ($action == 'listar') {
    $sql = "SELECT * FROM usuarios ORDER BY estUsu DESC, nomUsu ASC";
    $query = $conector->query($sql);
    if ($query->num_rows > 0):
?>
<table class="table table-hover table-bordered table-sm dt-responsive" id="tbl_usuarios">
  <thead class="table-warning">
    <tr>
      <th>N°</th>
      <th>DNI</th>
      <th>Nombres y Apellidos</th>
      <th>Correo</th>
      <th>Celular</th>
      <th>Rol</th>
      <th>Estado</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php
    $i = 1;
    while ($row = $query->fetch_assoc()):
      $est = $row['estUsu'] == 1
        ? '<span class="badge bg-success">Activo</span>'
        : '<span class="badge bg-danger">Bloqueado</span>';
      $rol = $row['rolUsu'] == 0
        ? '<span class="badge bg-warning text-dark">Admin</span>'
        : '<span class="badge bg-secondary">Usuario</span>';
?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td><?php echo $row['dniUsu']; ?></td>
      <td><?php echo $row['nomUsu'] . ' ' . $row['apeUsu']; ?></td>
      <td><?php echo $row['emaUsu']; ?></td>
      <td><?php echo $row['celUsu']; ?></td>
      <td class="text-center"><?php echo $rol; ?></td>
      <td class="text-center"><?php echo $est; ?></td>
      <td class="text-center">
        <div class="btn-group btn-group-sm">
          <button class="btn btn-primary btn-editar-usu"
            data-id="<?php echo $row['codUsu']; ?>"
            data-nom="<?php echo htmlspecialchars($row['nomUsu']); ?>"
            data-app="<?php echo htmlspecialchars($row['apeUsu']); ?>"
            data-dni="<?php echo $row['dniUsu']; ?>"
            data-cel="<?php echo $row['celUsu']; ?>"
            data-fn="<?php echo $row['fnaUsu']; ?>"
            data-email="<?php echo htmlspecialchars($row['emaUsu']); ?>"
            data-sex="<?php echo $row['sexUsu']; ?>"
            data-est="<?php echo $row['estUsu']; ?>"
            title="Editar">
            <i class="bi bi-pencil-fill"></i>
          </button>
          <button class="btn btn-danger btn-eliminar-usu"
            data-id="<?php echo $row['codUsu']; ?>"
            title="Eliminar">
            <i class="bi bi-trash-fill"></i>
          </button>
        </div>
      </td>
    </tr>
<?php endwhile; ?>
  </tbody>
</table>
<script>
$(document).ready(function() {
  $('#tbl_usuarios').DataTable({
    responsive: true,
    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
    dom: 'Bfrtip',
    buttons: [
      { extend: 'excelHtml5', text: '<i class="bi bi-file-earmark-excel"></i>', className: 'btn btn-sm btn-success', title: 'Usuarios' },
      { extend: 'pdfHtml5',   text: '<i class="bi bi-file-earmark-pdf"></i>',   className: 'btn btn-sm btn-danger',  title: 'Usuarios' },
      { extend: 'print',      text: '<i class="bi bi-printer"></i>',             className: 'btn btn-sm btn-secondary', title: 'Usuarios' }
    ]
  });
});
</script>
<?php
    else:
      echo '<div class="alert alert-warning">No hay usuarios registrados.</div>';
    endif;
  }
?>
