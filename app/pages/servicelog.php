<style>
  #logview {
    max-height: 250px;
    overflow: auto;
  }

  ::-webkit-scrollbar {
    width: 40px;
    background-color: white;
  }

  ::-webkit-scrollbar-thumb {
    background-color: black;
  }
</style>

<p>Events are organized by time in descending order.</p>

<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  if(!isset($_SESSION['operator']))
    die('User is not authenticated.');

  $_SESSION['page'] = "servicelog";

  require_once __DIR__ . '\..\..\backend\servicelog.php';

  $servicelog = new ServiceLog();

  $displayed = 25;

  if(!isset($_POST['offset'])) {
    $offset = 0;
  } else {
    $offset = $_POST['offset'];
    
    if($offset < 0)
      $offset = 0;
    elseif($offset > $servicelog->getEventCount() - $displayed)
      $offset = $servicelog->getEventCount() - $displayed;
  }

  $events = $servicelog->getEvents($displayed, $offset);

  echo "<div id=\"logview\">";
  echo "<table>";
  echo "<thead><tr><th>Time</th><th>Source</th><th>Event</th></tr></thead><tbody>";

  foreach($events as $event) {
    $log = explode("\t", $event);

    echo "<tr>";
    echo "<td>" . $log[0] . "</td>";
    echo "<td>" . $log[1] . "</td>";
    echo "<td>" . $log[2] . "</td>";
    echo "</tr>";
  }

  echo "</tbody></table>";
  echo "</div>";
?>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('servicelog', true, { offset: <?php echo $offset - $displayed; ?>}); return false;">Newer</a>
  <a class="button small" onclick="loadPage('servicelog', true, { offset: <?php echo $offset + $displayed; ?>}); return false;">Older</a>
  <a class="button small" onclick="loadPage('menu'); return false;">Go Back</a>
</div>