<?php
  include('config.php');

  global $CFG;

  $CFG->dirroot = __DIR__;
  
  $data = array();

  $data['wwwroot'] = $CFG->wwwroot;
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