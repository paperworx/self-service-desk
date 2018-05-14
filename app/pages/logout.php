<?php
  session_start();

  if(!isset($_SESSION['card']) && !isset($_SESSION['operator_mode'])) {
    die('Not logged in.');
  }

  require_once __DIR__ . '\..\..\backend\servicelog.php';

  $servicelog = new ServiceLog();

  if(isset($_SESSION['operator_mode']) && $_SESSION['operator_mode']) {
    $servicelog->logEvent("Operator logged out.");
  } else {
    $servicelog->logEvent($_SESSION['name'] . " logged out.");
  }

  session_destroy();
?>

<script type="text/javascript">
  loadPage('login');
</script>