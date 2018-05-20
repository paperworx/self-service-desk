<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  if(!isset($_SESSION['operator']))
    die('User is not authenticated.');

  $_SESSION['page'] = "associatecard";

  require_once __DIR__ . '\..\..\backend\activedirectory.php';
?>

<p>This feature is not available yet.</p>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('menu'); return false;">Go Back</a>
</div>