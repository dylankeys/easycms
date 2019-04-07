<?php
  session_start();
  include('config.php');
  include('lib.php');

  require_once('vendor/autoload.php');

  $m = new Mustache_Engine;

  $template = file_get_contents('templates/home.mustache');

  echo $m->render($template, $data);