function cargarJugadores() {
  $('#loader_jug').show();
  $.ajax({
    url: 'query/jugadores_ajax.php', data: { action: 'listar' },
    success: function(data) { $('.div_jugadores').html(data); $('#loader_jug').hide(); }
  });
}

$(document).on('click', '.btn-editar-jug', function() {
  $('#ujg_id').val($(this).data('id'));
  $('#ujg_nom').val($(this).data('nom'));
  $('#ujg_app').val($(this).data('app'));
  $('#ujg_dni').val($(this).data('dni'));
  $('#ujg_cel').val($(this).data('cel'));
  $('#ujg_fn').val($(this).data('fn'));
  $('#ujg_pos').val($(this).data('pos'));
  $('#ujg_num').val($(this).data('num'));
  $('#ujg_equipo').val($(this).data('equipo'));
  $('#ujg_est').val($(this).data('est'));
  $('#titEditJug').html('<i class="bi bi-pencil-square"></i> Editar: ' + $(this).data('nom'));
  $('#modalEditJug').modal('show');
});

$('#form_insert_jug').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'POST', url: 'query/jugadores_insert.php',
    data: new FormData(this), contentType: false, processData: false,
    success: function(resp) {
      $('#resp_ins_jug').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalRegJug').modal('hide');
          $('#form_insert_jug')[0].reset();
          $('#resp_ins_jug').html('');
          cargarJugadores();
        }, 1500);
      }
    }
  });
});

$('#form_update_jug').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'POST', url: 'query/jugadores_update.php',
    data: new FormData(this), contentType: false, processData: false,
    success: function(resp) {
      $('#resp_upd_jug').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalEditJug').modal('hide');
          $('#resp_upd_jug').html('');
          cargarJugadores();
        }, 1500);
      }
    }
  });
});

$(document).on('click', '.btn-eliminar-jug', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: '¿Eliminar jugador?', icon: 'warning', showCancelButton: true,
    confirmButtonColor: '#dc3545', cancelButtonText: 'Cancelar', confirmButtonText: 'Eliminar'
  }).then(function(r) {
    if (r.isConfirmed) {
      $.post('query/jugadores_delete.php', { id: id }, function() {
        Swal.fire('Eliminado', 'Jugador eliminado.', 'success');
        cargarJugadores();
      });
    }
  });
});
