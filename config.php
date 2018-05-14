<?php
  // Prerequisites:
  //  sqlite3 php module
  //  openssl php module
  //  ldap php module
  //  ldaps has been setup
  //  valid certificate to connect to AD over ldaps
  //  ad user with delegated privileges to be able to see user info and reset passwords + unlock accounts

  define('COMPANY', "Acme Corporation");

  define('ENABLE_ASSOCIATE_CARD', 0); // UNFINISHED
  define('ENABLE_CHECK_CARD', 0); // UNFINISHED

  define('LDAP_HOST', "dc01.example.com");
  define('LDAP_PORT', 636);
  define('LDAP_USER', "CN=Example Web App,CN=Users,DC=example,DC=com");
  define('LDAP_PASS', "password");
  define('LDAP_FQDN', "DC=example,DC=com");
  define('LDAP_ATTRIBUTE', "employeeID");

  define('SERVICE_PIN', "000000");
?>