<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  if(!isset($_SESSION['operator_mode']))
    die('User is not authenticated.');

  $_SESSION['page'] = "associatecard";

  require_once __DIR__ . '\..\..\backend\activedirectory.php';
?>

<p>This page is under construction.</p>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('ops'); return false;">Go Back</a>
</div>