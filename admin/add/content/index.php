<?php
  session_start();

  include($_SERVER['DOCUMENT_ROOT'].'/lib.php');

  require_once($CFG->dirroot.'/vendor/autoload.php');

  $m = new Mustache_Engine;

  $template = file_get_contents($CFG->dirroot.'/templates/admin/content.mustache');

  $dbQuery=$db->prepare("SELECT id, name FROM `sections` ORDER BY `position` ASC");
  $dbQuery->execute();

  while ($dbRow = $dbQuery->fetch(PDO::FETCH_ASSOC))
  {
    $section_id = $dbRow["id"];
    $section_name = $dbRow["name"];

    $section_data = array(
      'section_id' => $section_id,
      'section_name' => $section_name
    );

    $dbQueryContent=$db->prepare("SELECT id, name, main FROM `content` WHERE sectionid = :sectionid");
    $dbParamsContent = array('sectionid'=>$section_id);
    $dbQueryContent->execute($dbParamsContent);

    while ($dbRowContent = $dbQueryContent->fetch(PDO::FETCH_ASSOC))
    {
      $section_id = $dbRowContent["id"];
      $section_name = $dbRowContent["name"];

      $content_data = array(
        'content_id' => $content_id,
        'content_name' => $content_name
      );

      $section_data['content_manage'][] = $content_data;
    }


    $data['sections_manage'][] = $section_data;
  }

  echo $m->render($template, $data);