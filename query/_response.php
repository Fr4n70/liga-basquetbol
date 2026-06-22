<?php
  if (isset($errors)) {
    echo '<div class="alert alert-danger alert-dismissible fade show py-2">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <i class="bi bi-exclamation-circle-fill"></i> ' . implode('<br>', $errors) . '
    </div>';
  }
  if (isset($messages)) {
    echo '<div class="alert alert-success alert-dismissible fade show py-2">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <i class="bi bi-check-circle-fill"></i> ' . implode('<br>', $messages) . '
    </div>';
  }
?>
