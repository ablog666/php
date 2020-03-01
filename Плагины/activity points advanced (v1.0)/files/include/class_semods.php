<?php
/* 
 * SEMods static class
 *
 * Copyright (c) 2008 SocialEngineMods.Net
 *
 */

$semods_settings_cache = null;

class semods {
  // cached settings


  function g(&$var, $key, $default = null){ 
      return isset($var[$key]) ? $var[$key] : $default;
  }
  
  function get($key, $default = null)     { return semods::g($_GET, $key, $default);      }
  function session($key, $default = null) { return semods::g($_SESSION, $key, $default);  }
  function post($key, $default = null)    { return semods::g($_POST, $key, $default);     }
  function request($key, $default = null) { return semods::g($_REQUEST, $key, $default);  }
  
  function getpost($key, $default = null) { return isset($_GET[$key]) ? $_GET [$key] : (isset($_POST[$key]) ? $_POST[$key] : $default); }

  
  /* DATABASE */
  
  function db_query_array($query) {
      global $database;
      
      $result = $database->database_query($query);
      return $result ? $database->database_fetch_array($result) : false;
  }
  
  function db_query_assoc($query) {
      global $database;
      
      $result = $database->database_query($query);
      return $result ? $database->database_fetch_assoc($result) : false;
  
  }
  
  function db_query_count($query) {
      $dbr = semods::db_query_array($query );
      if($dbr === false)
          return 0;
      
      return $dbr[0];
  }

  function db_query_affected_rows($query) {
      global $database;

      $result = $database->database_query($query);
      return $result ? $database->database_affected_rows($database->database_connection) : false;
  }
  

  /* Settings */


  function get_settings() {
      global $semods_settings_cache;
      
      if(is_null($settings_cache)) {
          $semods_settings_cache = semods::db_query_assoc( 'SELECT * FROM se_semods_settings' );
      }
      
      return $semods_settings_cache;
  }
  
  function get_setting($setting) {
    $setting_key = 'setting_' . $setting;
    $settings = semods::get_settings();
    if($settings && isset($settings[$setting_key]))
      return $settings[$setting_key];
    
    return false;
  }
  
  
}

?>