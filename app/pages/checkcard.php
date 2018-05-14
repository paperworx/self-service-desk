<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  $_SESSION['page'] = "checkcard";

  if(!isset($_SESSION['card']))
    die('User is not authenticated.');

  require_once __DIR__ . '\..\..\backend\activedirectory.php';
?>

<p>This page is under construction.</p>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('menu'); return false;">Go Back</a>
</div>