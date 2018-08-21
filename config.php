<?php
/**
 * For Development Purposes
 */
ini_set("display_errors", "on");

require __DIR__ . "/LS.php";
//require "LS.php";

$LS = new \Fr\LS(array(
  "db" => array(
    "host" => "mysql.sfsiren.net",
    "port" => 3306,
    "username" => "sfsirenuser",
    "password" => "x2F9b8Fo8xCVDg62UtMxT2xi2iCM",
    "name" => "sirensdb",
    "table" => "users"
  ),
  "features" => array(
    "auto_init" => true
  ),
  "pages" => array(
    "no_login" => array(
      "/",
      "/reset.php",
      "/register.php"
    ),
    "everyone" => array(
      "/status.php",
      "/checkins.php",
      "/leaderboard.php",
      "/siren.php",
      "/user.php",
      "/view_sirens.php"
    ),
    "login_page" => "/login.php",
    "home_page" => "/checkins.php"
  )
));
