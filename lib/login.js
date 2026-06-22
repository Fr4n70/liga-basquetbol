$('#frm_login').on('submit', function(e) {
  e.preventDefault();
  var datos = new FormData(this);
  $.ajax({
    type: 'POST',
    url: 'lib/PHP_login.php',
    data: datos,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $('#resp_login').html('<div class="alert alert-info"><i class="bi bi-hourglass-split"></i> Verificando...</div>');
    },
    success: function(resp) {
      try {
        var r = JSON.parse(resp);
        if (r.status === 'ok') {
          $('#resp_login').html('<div class="alert alert-success"><i class="bi bi-check-circle"></i> ' + r.msg + '</div>');
          setTimeout(function() { window.location.href = 'inicio.php'; }, 1500);
        } else {
          $('#resp_login').html('<div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> ' + r.msg + '</div>');
        }
      } catch(ex) {
        $('#resp_login').html('<div class="alert alert-danger">Error de servidor.</div>');
      }
    },
    error: function() {
      $('#resp_login').html('<div class="alert alert-danger">Error de conexión.</div>');
    }
  });
});
