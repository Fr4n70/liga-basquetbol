function cargarEquipos() {
  $('#loader_equ').show();
  $.ajax({
    url: 'query/equipos_ajax.php', data: { action: 'listar' },
    success: function(data) { $('.div_equipos').html(data); $('#loader_equ').hide(); }
  });
}

$(document).on('click', '.btn-editar-equ', function() {
  $('#ueq_id').val($(this).data('id'));
  $('#ueq_nom').val($(this).data('nom'));
  $('#ueq_ciudad').val($(this).data('ciudad'));
  $('#ueq_color').val($(this).data('color'));
  $('#ueq_est').val($(this).data('est'));
  $('#titEditEqu').html('<i class="bi bi-pencil-square"></i> Editar: ' + $(this).data('nom'));
  $('#modalEditEqu').modal('show');
});

$('#form_insert_equ').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'POST', url: 'query/equipos_insert.php',
    data: new FormData(this), contentType: false, processData: false,
    success: function(resp) {
      $('#resp_ins_equ').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalRegEqu').modal('hide');
          $('#form_insert_equ')[0].reset();
          $('#resp_ins_equ').html('');
          cargarEquipos();
        }, 1500);
      }
    }
  });
});

$('#form_update_equ').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'POST', url: 'query/equipos_update.php',
    data: new FormData(this), contentType: false, processData: false,
    success: function(resp) {
      $('#resp_upd_equ').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalEditEqu').modal('hide');
          $('#resp_upd_equ').html('');
          cargarEquipos();
        }, 1500);
      }
    }
  });
});

$(document).on('click', '.btn-eliminar-equ', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: '¿Eliminar equipo?', text: 'Se eliminarán también sus jugadores asociados.',
    icon: 'warning', showCancelButton: true,
    confirmButtonColor: '#dc3545', cancelButtonText: 'Cancelar', confirmButtonText: 'Eliminar'
  }).then(function(r) {
    if (r.isConfirmed) {
      $.post('query/equipos_delete.php', { id: id }, function() {
        Swal.fire('Eliminado', 'Equipo eliminado.', 'success');
        cargarEquipos();
      });
    }
  });
});
