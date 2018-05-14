<?php

require_once __DIR__ . '\main.php';

class ActiveDirectory extends SelfServiceDesk {

  public function generatePassword() {
    $words[] = "Computing";
    $words[] = "Positive";
    $words[] = "Packet";
    $words[] = "Physics";
    $words[] = "Enhance";
    $words[] = "Electron";
    $words[] = "Quality";
    $words[] = "Assembly";
    $words[] = "Energy";
    $words[] = "Document";
    $words[] = "Broadcast";
    $words[] = "Quarter";
    $words[] = "Service";
    $words[] = "Approval";
    $words[] = "Contact";
    $words[] = "Session";
    $words[] = "Classify";
    $words[] = "Persist";
    $words[] = "Exceed";
    $words[] = "Autonomy";

    $word = $words[rand(0, count($words) - 1)];
    $number = rand(10, 99);
    $symbol = (rand(0, 1) ? "?" : "!");
    $password = $word . $number . $symbol;

    return $password;
  }

  public function getUserByCard($card) {
    $card = addslashes($card);
    $attribute = addslashes(LDAP_ATTRIBUTE);
    $ldap = ldap_connect("ldaps://" . LDAP_HOST, LDAP_PORT);

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, LDAP_USER, LDAP_PASS);

    if(!$bind)
      return ['status' => "NO_CONNECTION"];

    $search = ldap_search($ldap, LDAP_FQDN, "($attribute=$card)", array("displayName", "sAMAccountName", "$attribute", "userAccountControl"));
    $users = ldap_get_entries($ldap, $search);

    ldap_close($ldap);

    if($users['count'] === 0)
      return ['status' => "NOT_FOUND"];

    if($users['count'] > 1)
      return ['status' => "DUPLICATES"];

    $user = $users[0];

    $displayName = $user['displayname'][0];
    $sAMAccountName = $user['samaccountname'][0];
    $ident = $user[strtolower($attribute)][0];
    $userAccountControl = $user['useraccountcontrol'][0];
    $accountDisabled = ($userAccountControl & 0x10002) == 0x10002;

    if($accountDisabled)
      return ['status' => "DISABLED"];

    $info = [
      'name' => $displayName,
      'username' => $sAMAccountName,
      'card' => $ident,
      'status' => "SUCCESS"
    ];

    return $info;
  }

  public function updatePassword($username, $password, $permanent = false) {
    $ldap = ldap_connect("ldaps://" . LDAP_HOST, LDAP_PORT);

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    @ldap_start_tls($ldap);

    $bind = @ldap_bind($ldap, LDAP_USER, LDAP_PASS);

    if(!$bind)
      return ['status' => "NO_CONNECTION"];

    $search = ldap_search($ldap, LDAP_FQDN, "(sAMAccountName=$username)", array("sAMAccountName", "userAccountControl"));
    $users = ldap_get_entries($ldap, $search);

    if($users['count'] === 0)
      return ['status' => "NOT_FOUND"];

    $user = $users[0];

    $fqdn = $user['dn'];
    $sAMAccountName = $user['samaccountname'][0];
    $userAccountControl = $user['useraccountcontrol'][0];
    $accountDisabled = ($userAccountControl & 0x10002) == 0x10002;
    $accountLocked = ($userAccountControl & 0x10010) == 0x10010;

    if($accountDisabled)
      return ['status' => "DISABLED"];

    if($accountLocked) {
      $userAccountControl -= 0x10010;
      $userAccountControl = base_convert($userAccountControl, 10, 16);
    }

    $encPassword = "";
    $password = "\"" . $password . "\"";

    for($i = 0; $i < strlen($password); $i++)
      $encPassword .= "{$password{$i}}\000";

    $permanent = ($permanent ? -1 : 0);

    if(!@ldap_modify($ldap, $fqdn, array("unicodePwd" => $encPassword, "pwdLastSet" => $permanent, "userAccountControl" => $userAccountControl)))
      return ['status' => "NO_CHANGE"];

    ldap_close($ldap);

    $info = [
      'username' => $sAMAccountName,
      'status' => "SUCCESS"
    ];

    return $info;
  }

}