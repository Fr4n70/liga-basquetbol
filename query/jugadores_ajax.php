<?php
  include_once '../config/conexion.php';
  $action = $_REQUEST['action'] ?? '';
  if ($action == 'listar') {
    $q = $conector->query("
      SELECT j.*, e.nomEqu FROM jugadores j
      JOIN equipos e ON j.codEqu = e.codEqu
      ORDER BY e.nomEqu, j.nomJug ASC
    ");
    if ($q->num_rows > 0):
?>
<table class="table table-hover table-bordered table-sm" id="tbl_jugadores">
  <thead class="table-warning">
    <tr><th>N°</th><th>Equipo</th><th>Jugador</th><th>DNI</th><th>#</th><th>Posición</th><th>Estado</th><th></th></tr>
  </thead>
  <tbody>
<?php
    $i=1;
    while($row=$q->fetch_assoc()):
      $est = $row['estJug']==1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>';
?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td><i class="bi bi-shield-fill text-warning"></i> <?php echo $row['nomEqu']; ?></td>
      <td><?php echo $row['nomJug'].' '.$row['apeJug']; ?></td>
      <td><?php echo $row['dniJug']; ?></td>
      <td class="text-center"><span class="badge bg-dark"><?php echo $row['numJug']; ?></span></td>
      <td><?php echo $row['posJug']; ?></td>
      <td class="text-center"><?php echo $est; ?></td>
      <td class="text-center">
        <div class="btn-group btn-group-sm">
          <button class="btn btn-primary btn-editar-jug"
            data-id="<?php echo $row['codJug']; ?>"
            data-equipo="<?php echo $row['codEqu']; ?>"
            data-nom="<?php echo htmlspecialchars($row['nomJug']); ?>"
            data-app="<?php echo htmlspecialchars($row['apeJug']); ?>"
            data-dni="<?php echo $row['dniJug']; ?>"
            data-cel="<?php echo $row['celJug']; ?>"
            data-fn="<?php echo $row['fnaJug']; ?>"
            data-pos="<?php echo $row['posJug']; ?>"
            data-num="<?php echo $row['numJug']; ?>"
            data-est="<?php echo $row['estJug']; ?>">
            <i class="bi bi-pencil-fill"></i>
          </button>
          <button class="btn btn-danger btn-eliminar-jug" data-id="<?php echo $row['codJug']; ?>">
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
  $('#tbl_jugadores').DataTable({
    responsive:true,
    language:{url:'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'},
    dom:'Bfrtip',
    buttons:[
      {extend:'excelHtml5',text:'<i class="bi bi-file-earmark-excel"></i>',className:'btn btn-sm btn-success',title:'Jugadores'},
      {extend:'pdfHtml5',text:'<i class="bi bi-file-earmark-pdf"></i>',className:'btn btn-sm btn-danger',title:'Jugadores'},
      {extend:'print',text:'<i class="bi bi-printer"></i>',className:'btn btn-sm btn-secondary',title:'Jugadores'}
    ]
  });
});
</script>
<?php
    else: echo '<div class="alert alert-warning">No hay jugadores registrados.</div>';
    endif;
  }
?>
