<?php
// Simple class to retrieve credentials from an .ini file

class Credentials
{
  var $key_array;

  function Credentials() {
    $this->key_array = parse_ini_file("..\application\configs\cloud.ini", true);
  }

  function getCredential($group, $key) {
    return $this->key_array[$group][$key];
  }
}
?>