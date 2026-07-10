<?php
  include_once '../config/conexion.php';
  $action = $_REQUEST['action'] ?? '';
  if ($action == 'listar') {
    $q = $conector->query("SELECT * FROM equipos ORDER BY estEqu DESC, nomEqu ASC");
    if ($q->num_rows > 0):
?>
<table class="table table-hover table-bordered table-sm" id="tbl_equipos">
  <thead class="table-warning">
    <tr><th>N°</th><th>Equipo</th><th>Ciudad</th><th>Colores</th><th>Jugadores</th><th>Estado</th><th></th></tr>
  </thead>
  <tbody>
<?php
    $i=1;
    while($row=$q->fetch_assoc()):
      $njug = $conector->query("SELECT COUNT(*) as t FROM jugadores WHERE codEqu=".$row['codEqu']." AND estJug=1")->fetch_assoc()['t'];
      $est  = $row['estEqu']==1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>';
?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td><i class="bi bi-shield-fill text-warning"></i> <?php echo $row['nomEqu']; ?></td>
      <td><?php echo $row['ciudadEqu']; ?></td>
      <td><?php echo $row['colorEqu']; ?></td>
      <td class="text-center"><span class="badge bg-info"><?php echo $njug; ?></span></td>
      <td class="text-center"><?php echo $est; ?></td>
      <td class="text-center">
        <div class="btn-group btn-group-sm">
          <button class="btn btn-success btn-perfil-equ"
            data-id="<?php echo $row['codEqu']; ?>"
            title="Ver perfil">
            <i class="bi bi-eye-fill"></i>
          </button>
          <button class="btn btn-primary btn-editar-equ"
            data-id="<?php echo $row['codEqu']; ?>"
            data-nom="<?php echo htmlspecialchars($row['nomEqu']); ?>"
            data-ciudad="<?php echo htmlspecialchars($row['ciudadEqu']); ?>"
            data-color="<?php echo htmlspecialchars($row['colorEqu']); ?>"
            data-est="<?php echo $row['estEqu']; ?>">
            <i class="bi bi-pencil-fill"></i>
          </button>
          <button class="btn btn-danger btn-eliminar-equ" data-id="<?php echo $row['codEqu']; ?>">
            <i class="bi bi-trash-fill"></i>
          </button>
        </div>
      </td>
    </tr>
<?php endwhile; ?>
  </tbody>
</table>
<script>
$(document).ready(function(){
  $('#tbl_equipos').DataTable({
    responsive:true,
    language:{url:'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'},
    dom:'Bfrtip',
    buttons:[
      {extend:'excelHtml5',text:'<i class="bi bi-file-earmark-excel"></i>',className:'btn btn-sm btn-success',title:'Equipos'},
      {extend:'pdfHtml5',text:'<i class="bi bi-file-earmark-pdf"></i>',className:'btn btn-sm btn-danger',title:'Equipos'},
      {extend:'print',text:'<i class="bi bi-printer"></i>',className:'btn btn-sm btn-secondary',title:'Equipos'}
    ]
  });
});
</script>
<?php
    else: echo '<div class="alert alert-warning">No hay equipos registrados.</div>';
    endif;
  }
?>