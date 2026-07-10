<?php
include_once '../config/conexion.php';
$id = intval($_REQUEST['id'] ?? 0);

$eq = $conector->query("SELECT * FROM equipos WHERE codEqu=$id")->fetch_assoc();
$jugadores = $conector->query("
    SELECT * FROM jugadores 
    WHERE codEqu=$id AND estJug=1 
    ORDER BY numJug ASC
");

// Partidos del equipo
$stats = $conector->query("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN estPar=2 AND equLocPar=$id AND ptsLocPar > ptsVisPar THEN 1
                 WHEN estPar=2 AND equVisPar=$id AND ptsVisPar > ptsLocPar THEN 1 ELSE 0 END) as ganados,
        SUM(CASE WHEN estPar=2 AND equLocPar=$id AND ptsLocPar < ptsVisPar THEN 1
                 WHEN estPar=2 AND equVisPar=$id AND ptsVisPar < ptsLocPar THEN 1 ELSE 0 END) as perdidos
    FROM partidos 
    WHERE equLocPar=$id OR equVisPar=$id
")->fetch_assoc();
?>
<div class="card card-outline card-warning mb-0">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <p><i class="bi bi-shield-fill text-warning"></i> <strong>Equipo:</strong> <?php echo $eq['nomEqu']; ?></p>
        <p><i class="bi bi-geo-alt-fill text-danger"></i> <strong>Ciudad:</strong> <?php echo $eq['ciudadEqu']; ?></p>
        <p><i class="bi bi-palette-fill text-primary"></i> <strong>Colores:</strong> <?php echo $eq['colorEqu']; ?></p>
      </div>
      <div class="col-md-6">
        <div class="row text-center">
          <div class="col-4">
            <div class="card bg-primary text-white py-2">
              <h5><?php echo $stats['total'] ?? 0; ?></h5>
              <small>Partidos</small>
            </div>
          </div>
          <div class="col-4">
            <div class="card bg-success text-white py-2">
              <h5><?php echo $stats['ganados'] ?? 0; ?></h5>
              <small>Ganados</small>
            </div>
          </div>
          <div class="col-4">
            <div class="card bg-danger text-white py-2">
              <h5><?php echo $stats['perdidos'] ?? 0; ?></h5>
              <small>Perdidos</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h6 class="border-bottom pb-2"><i class="bi bi-people-fill"></i> Plantilla (<?php echo $jugadores->num_rows; ?> jugadores)</h6>
    <table class="table table-sm table-bordered table-hover">
      <thead class="table-warning">
        <tr>
          <th class="text-center">Camiseta</th>
          <th>Jugador</th>
          <th>Posición</th>
          <th>DNI</th>
        </tr>
      </thead>
      <tbody>
        <?php while($j = $jugadores->fetch_assoc()): ?>
        <tr>
          <td class="text-center"><span class="badge bg-dark"><?php echo $j['numJug']; ?></span></td>
          <td><i class="bi bi-person-fill"></i> <?php echo $j['nomJug'].' '.$j['apeJug']; ?></td>
          <td><?php echo $j['posJug']; ?></td>
          <td><?php echo $j['dniJug']; ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>