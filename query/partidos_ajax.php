<?php
  include_once '../config/conexion.php';
  $action = $_REQUEST['action'] ?? '';

  if ($action == 'listar') {
    $q = $conector->query("
      SELECT p.*,
             e1.nomEqu AS local,
             e2.nomEqu AS visitante
      FROM partidos p
      JOIN equipos e1 ON p.equLocPar = e1.codEqu
      JOIN equipos e2 ON p.equVisPar = e2.codEqu
      ORDER BY p.fechaPar DESC, p.horaPar DESC
    ");

    $badge = [
      0 => '<span class="badge bg-secondary">Programado</span>',
      1 => '<span class="badge bg-warning text-dark">En Juego</span>',
      2 => '<span class="badge bg-success">Finalizado</span>',
    ];

    if ($q->num_rows > 0):
?>
<table class="table table-hover table-bordered table-sm" id="tbl_partidos">
  <thead class="table-warning">
    <tr>
      <th>N°</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th class="text-end">Local</th>
      <th class="text-center">Resultado</th>
      <th>Visitante</th>
      <th>Lugar</th>
      <th class="text-center">Estado</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php
    $i = 1;
    while ($row = $q->fetch_assoc()):
      $est    = intval($row['estPar']);
      $loc_w  = ($est == 2 && $row['ptsLocPar'] > $row['ptsVisPar']) ? 'fw-bold text-success' : '';
      $vis_w  = ($est == 2 && $row['ptsVisPar'] > $row['ptsLocPar']) ? 'fw-bold text-success' : '';
      $res    = ($est >= 1)
        ? "<span class='fw-bold fs-6 {$loc_w}'>{$row['ptsLocPar']}</span> - <span class='fw-bold fs-6 {$vis_w}'>{$row['ptsVisPar']}</span>"
        : '<span class="text-muted">— vs —</span>';
?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td><?php echo date('d/m/Y', strtotime($row['fechaPar'])); ?></td>
      <td><?php echo substr($row['horaPar'], 0, 5); ?></td>
      <td class="text-end fw-semibold"><?php echo $row['local']; ?></td>
      <td class="text-center"><?php echo $res; ?></td>
      <td class="fw-semibold"><?php echo $row['visitante']; ?></td>
      <td><small><?php echo $row['lugarPar']; ?></small></td>
      <td class="text-center"><?php echo $badge[$est]; ?></td>
      <td class="text-center">
        <div class="btn-group btn-group-sm">
          <?php if ($est < 2): ?>
          <button class="btn btn-success btn-resultado"
            data-id="<?php echo $row['codPar']; ?>"
            data-local="<?php echo htmlspecialchars($row['local']); ?>"
            data-visitante="<?php echo htmlspecialchars($row['visitante']); ?>"
            data-ptsloc="<?php echo $row['ptsLocPar']; ?>"
            data-ptsvis="<?php echo $row['ptsVisPar']; ?>"
            data-est="<?php echo $est; ?>"
            title="Registrar resultado">
            <i class="bi bi-pencil-square"></i>
          </button>
          <?php endif; ?>
          <button class="btn btn-danger btn-eliminar-par"
            data-id="<?php echo $row['codPar']; ?>"
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
$(document).ready(function(){
  $('#tbl_partidos').DataTable({
    responsive: true,
    order: [[1,'desc']],
    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
    dom: 'Bfrtip',
    buttons: [
      { extend:'excelHtml5', text:'<i class="bi bi-file-earmark-excel"></i>', className:'btn btn-sm btn-success', title:'Partidos' },
      { extend:'pdfHtml5',   text:'<i class="bi bi-file-earmark-pdf"></i>',   className:'btn btn-sm btn-danger',  title:'Partidos' },
      { extend:'print',      text:'<i class="bi bi-printer"></i>',             className:'btn btn-sm btn-secondary', title:'Partidos' }
    ]
  });
});
</script>
<?php
    else:
      echo '<div class="alert alert-warning">No hay partidos programados aún.</div>';
    endif;
  }
?>
