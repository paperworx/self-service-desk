<?php
  session_start();

  if(!isset($_SESSION['card']) && !isset($_SESSION['operator']))
    die('Not logged in.');

  require_once __DIR__ . '\..\..\backend\servicelog.php';

  $servicelog = new ServiceLog();

  $servicelog->logEvent($_SESSION['name'] . " logged out.");

  session_destroy();
?>

<script type="text/javascript">
  loadPage('login');
</script>