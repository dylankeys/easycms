<?php
  include('config.php');

  global $CFG;

  $CFG->dirroot = __DIR__;
  $CFG->server_name = $_SERVER['SERVER_NAME'];
  
  $data = array();

  $data['server_name'] = $CFG->server_name;
  $data['year'] = date('Y');

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

    $data['sections_nav'][] = $section_data;

  }