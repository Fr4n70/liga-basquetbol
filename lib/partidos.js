function cargarPartidos() {
  $('#loader_par').show();
  $.ajax({
    url: 'query/partidos_ajax.php', data: { action: 'listar' },
    success: function(data) { $('.div_partidos').html(data); $('#loader_par').hide(); }
  });
}

// Abrir modal resultado
$(document).on('click', '.btn-resultado', function() {
  $('#res_id').val($(this).data('id'));
  $('#res_local_nom').text($(this).data('local'));
  $('#res_vis_nom').text($(this).data('visitante'));
  $('#res_pts_loc').val($(this).data('ptsloc'));
  $('#res_pts_vis').val($(this).data('ptsvis'));
  $('#res_est').val($(this).data('est'));
  $('#titResultado').html('<i class="bi bi-check2-square"></i> ' + $(this).data('local') + ' vs ' + $(this).data('visitante'));
  $('#modalResultado').modal('show');
});

// Programar partido
$('#form_insert_par').on('submit', function(e) {
  e.preventDefault();
  var local = $('select[name="local"]').val();
  var visitante = $('select[name="visitante"]').val();
  if (local === visitante) {
    $('#resp_ins_par').html('<div class="alert alert-danger">El equipo local y visitante no pueden ser el mismo.</div>');
    return;
  }
  $.ajax({
    type: 'POST', url: 'query/partidos_insert.php',
    data: new FormData(this), contentType: false, processData: false,
    success: function(resp) {
      $('#resp_ins_par').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalRegPar').modal('hide');
          $('#form_insert_par')[0].reset();
          $('#resp_ins_par').html('');
          cargarPartidos();
        }, 1500);
      }
    }
  });
});

// Guardar resultado
$('#form_resultado').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'POST', url: 'query/partidos_update.php',
    data: new FormData(this), contentType: false, processData: false,
    success: function(resp) {
      $('#resp_resultado').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalResultado').modal('hide');
          $('#resp_resultado').html('');
          cargarPartidos();
        }, 1500);
      }
    }
  });
});

// Eliminar partido
$(document).on('click', '.btn-eliminar-par', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: '¿Eliminar partido?',
    text: 'Se eliminará el partido y su resultado.',
    icon: 'warning', showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, eliminar'
  }).then(function(r) {
    if (r.isConfirmed) {
      $.post('query/partidos_delete.php', { id: id }, function() {
        Swal.fire('Eliminado', 'Partido eliminado.', 'success');
        cargarPartidos();
      });
    }
  });
});
