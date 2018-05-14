<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  $_SESSION['page'] = "operatorlogin";

  if(isset($_SESSION['operator_mode']) && $_SESSION['operator_mode'])
    session_destroy();

  if(isset($_POST['passcode']) && strlen($_POST['passcode']) != 0) {
    require_once __DIR__ . '\..\..\backend\servicelog.php';
    
    $servicelog = new ServiceLog();
    
    if($_POST['passcode'] === SERVICE_PIN) {
      $servicelog->logEvent("Operator logged in.");
      
      $_SESSION['operator_mode'] = true;
      
      header('Location: /pages/ops.php');
      return;
    } else {
      $servicelog->logEvent("Incorrect operator code entered.");
      
      echo '<p><span style="color: red;">Passcode not valid.</span></p>';
    }
  } else {
    echo '<p>Enter passcode to access operator functions:</p>';
  }
?>

<style>
  .numpad {
    text-align: center;
  }

  .numpad input {
    text-align: center;
    font-size: 6rem;
    width: 30rem;
    margin-bottom: 1rem;
    border: none;
    background-color: black;
    color: white;
  }
  
  .numpadbuttons {
    padding-bottom: 1rem;
  }

  .button.digit {
    padding: 15px;
    margin: 5px;
    font-size: 3rem;
  }
</style>

<div class="numpad">
  <form method="post">
    <input id="passcode" type="password" maxlength="<?php echo strlen(SERVICE_PIN); ?>" autocomplete="off" disabled>
  </form><br>
  <div class="numpadbuttons">
    <a class="button digit" onclick="inputDigit(7); return false;">7</a>
    <a class="button digit" onclick="inputDigit(8); return false;">8</a>
    <a class="button digit" onclick="inputDigit(9); return false;">9</a><br>
    <a class="button digit" onclick="inputDigit(4); return false;">4</a>
    <a class="button digit" onclick="inputDigit(5); return false;">5</a>
    <a class="button digit" onclick="inputDigit(6); return false;">6</a><br>
    <a class="button digit" onclick="inputDigit(1); return false;">1</a>
    <a class="button digit" onclick="inputDigit(2); return false;">2</a>
    <a class="button digit" onclick="inputDigit(3); return false;">3</a><br>
    <a class="button digit" onclick="inputDigit(0); return false;">0</a>
  </div>
</div>

<div class="subbuttons">
  <a class="button small" onclick="clearDigits(); return false">Clear</a>
  <a class="button small" onclick="loadPage('operatorlogin', true, { passcode: passcode.value }); return false;">Enter</a>
  <a class="button small" onclick="loadPage('login'); return false;">Go Back</a>
</div>

<script type="text/javascript">
  function inputDigit(digit) {
    var passcodeInput = $("#passcode");

    passcodeInput.val(passcodeInput.val() + digit);
  }

  function clearDigits() {
    var passcodeInput = $("#passcode");

    passcodeInput.val("");
  }
</script>