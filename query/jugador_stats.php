<?php
include_once '../config/conexion.php';
$id = intval($_REQUEST['id'] ?? 0);

$jug = $conector->query("
    SELECT j.*, e.nomEqu, e.codEqu FROM jugadores j
    JOIN equipos e ON j.codEqu = e.codEqu
    WHERE j.codJug=$id
")->fetch_assoc();

$codEqu = $jug['codEqu'];

// Partidos del equipo del jugador
$stats = $conector->query("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN estPar=2 AND equLocPar=$codEqu AND ptsLocPar > ptsVisPar THEN 1
                 WHEN estPar=2 AND equVisPar=$codEqu AND ptsVisPar > ptsLocPar THEN 1 ELSE 0 END) as ganados,
        SUM(CASE WHEN estPar=2 AND equLocPar=$codEqu AND ptsLocPar < ptsVisPar THEN 1
                 WHEN estPar=2 AND equVisPar=$codEqu AND ptsVisPar < ptsLocPar THEN 1 ELSE 0 END) as perdidos,
        SUM(CASE WHEN equLocPar=$codEqu THEN ptsLocPar
                 WHEN equVisPar=$codEqu THEN ptsVisPar ELSE 0 END) as total_puntos
    FROM partidos 
    WHERE equLocPar=$codEqu OR equVisPar=$codEqu
")->fetch_assoc();

$edad = $jug['fnaJug'] ? date_diff(date_create($jug['fnaJug']), date_create('today'))->y : 'N/A';
?>
<div class="card card-outline card-info mb-0">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <p><i class="bi bi-person-fill text-primary"></i> <strong>Jugador:</strong> <?php echo $jug['nomJug'].' '.$jug['apeJug']; ?></p>
        <p><i class="bi bi-shield-fill text-warning"></i> <strong>Equipo:</strong> <?php echo $jug['nomEqu']; ?></p>
        <p><i class="bi bi-diagram-3-fill"></i> <strong>Posición:</strong> <?php echo $jug['posJug']; ?></p>
        <p><i class="bi bi-hash"></i> <strong>Camiseta N°:</strong> <?php echo $jug['numJug']; ?></p>
      </div>
      <div class="col-md-6">
        <p><i class="bi bi-card-text"></i> <strong>DNI:</strong> <?php echo $jug['dniJug']; ?></p>
        <p><i class="bi bi-telephone-fill"></i> <strong>Celular:</strong> <?php echo $jug['celJug']; ?></p>
        <p><i class="bi bi-calendar-fill"></i> <strong>Nacimiento:</strong> <?php echo $jug['fnaJug'] ? date('d/m/Y', strtotime($jug['fnaJug'])) : 'N/A'; ?></p>
        <p><i class="bi bi-person-badge"></i> <strong>Edad:</strong> <?php echo $edad; ?> años</p>
      </div>
    </div>
    <h6 class="border-bottom pb-2"><i class="bi bi-bar-chart-fill"></i> Estadísticas del Equipo</h6>
    <div class="row text-center">
      <div class="col-md-3 col-6 mb-3">
        <div class="card bg-primary text-white py-2">
          <h4><?php echo $stats['total'] ?? 0; ?></h4>
          <small>Partidos</small>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-3">
        <div class="card bg-success text-white py-2">
          <h4><?php echo $stats['ganados'] ?? 0; ?></h4>
          <small>Ganados</small>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-3">
        <div class="card bg-danger text-white py-2">
          <h4><?php echo $stats['perdidos'] ?? 0; ?></h4>
          <small>Perdidos</small>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-3">
        <div class="card bg-warning text-dark py-2">
          <h4><?php echo $stats['total_puntos'] ?? 0; ?></h4>
          <small>Puntos</small>
        </div>
      </div>
    </div>
  </div>
</div>