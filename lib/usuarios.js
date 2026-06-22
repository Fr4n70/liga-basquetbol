// Cargar tabla de usuarios
function cargarUsuarios() {
  $('#loader_usu').show();
  $.ajax({
    url: 'query/usuarios_ajax.php',
    data: { action: 'listar' },
    success: function(data) {
      $('.div_usuarios').html(data);
      $('#loader_usu').hide();
    }
  });
}

// Abrir modal editar y cargar datos
$(document).on('click', '.btn-editar-usu', function() {
  $('#upd_id').val($(this).data('id'));
  $('#upd_nom').val($(this).data('nom'));
  $('#upd_app').val($(this).data('app'));
  $('#upd_dni').val($(this).data('dni'));
  $('#upd_cel').val($(this).data('cel'));
  $('#upd_fn').val($(this).data('fn'));
  $('#upd_email').val($(this).data('email'));
  $('#upd_est').val($(this).data('est'));
  if ($(this).data('sex') == 1) {
    $('#upd_M').prop('checked', true);
  } else {
    $('#upd_F').prop('checked', true);
  }
  $('#tituloEditar').html('<i class="bi bi-pencil-square"></i> Editar: ' + $(this).data('nom'));
  $('#modalEditar').modal('show');
});

// Insertar usuario
$('#form_insert_usu').on('submit', function(e) {
  e.preventDefault();
  var datos = new FormData(this);
  $.ajax({
    type: 'POST', url: 'query/usuarios_insert.php',
    data: datos, contentType: false, processData: false,
    beforeSend: function() { $('#resp_ins_usu').html('<span class="text-info">Procesando...</span>'); },
    success: function(resp) {
      $('#resp_ins_usu').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalRegistrar').modal('hide');
          $('#form_insert_usu')[0].reset();
          $('#resp_ins_usu').html('');
          cargarUsuarios();
        }, 1500);
      }
    }
  });
});

// Actualizar usuario
$('#form_update_usu').on('submit', function(e) {
  e.preventDefault();
  var datos = new FormData(this);
  $.ajax({
    type: 'POST', url: 'query/usuarios_update.php',
    data: datos, contentType: false, processData: false,
    beforeSend: function() { $('#resp_upd_usu').html('<span class="text-info">Procesando...</span>'); },
    success: function(resp) {
      $('#resp_upd_usu').html(resp);
      if (resp.indexOf('alert-success') !== -1) {
        setTimeout(function() {
          $('#modalEditar').modal('hide');
          $('#resp_upd_usu').html('');
          cargarUsuarios();
        }, 1500);
      }
    }
  });
});

// Eliminar usuario
$(document).on('click', '.btn-eliminar-usu', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: '¿Eliminar usuario?',
    text: 'Esta acción no se puede revertir.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, eliminar'
  }).then(function(result) {
    if (result.isConfirmed) {
      $.post('query/usuarios_delete.php', { id: id }, function(resp) {
        Swal.fire('Eliminado', 'Usuario eliminado.', 'success');
        cargarUsuarios();
      });
    }
  });
});
