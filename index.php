<?php
  session_start();
  include('config.php');
  include('lib.php');

  require_once('vendor/autoload.php');

  $m = new Mustache_Engine;
  $data = array();
  $template = file_get_contents('templates/home.mustache');

  $dbQuery=$db->prepare("SELECT `name` FROM `sections` ORDER BY `position` ASC");
  $dbQuery->execute();

  while ($dbRow = $dbQuery->fetch(PDO::FETCH_ASSOC))
  {
    $section_name=$dbRow["name"];
    $section_link=lcfirst($section_name);

    $section_data = array(
      'section_name' => $section_name,
      'section_link' => $section_link
    );

    $data['sections'][] = $section_data;

  }

  echo $m->render($template, $data);

  