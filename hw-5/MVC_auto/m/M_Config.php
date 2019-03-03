<?php

  class M_Config {
    function __construct() {
  
      // session_start();
    }
    function isAdmin() {
      return $_SESSION['isAdmin'] == true;
    }
    
    function db_connect(){
  
    }
  }