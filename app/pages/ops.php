<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  if(!isset($_SESSION['operator_mode']))
    die('User is not authenticated.');

  $_SESSION['page'] = "ops";
?>

<div class="buttons">
  <a class="button big" onclick="loadPage('servicelog'); return false;"><img src="servicelog.png"><br>Service Log</a>
</div>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('logout'); return false;">Operator Logout</a>
</div>