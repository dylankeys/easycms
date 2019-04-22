<?php
  session_start();

  include($_SERVER['DOCUMENT_ROOT'].'/lib.php');

  require_once($CFG->dirroot.'/vendor/autoload.php');

  $m = new Mustache_Engine;

  $template = file_get_contents($CFG->dirroot.'/templates/admin/content.mustache');

  if (isset($_POST['submit'])) {
    if (isset($_POST['add_page'])) {
      $page_name = $_POST['page_name'];
      $template = $_POST['templates'];
      $section_id = $_POST['section_id'];
      $main = 0; //Always set to zero as this is not the area for creating a new main section page

      $dbQuery=$db->prepare("INSERT INTO `content` VALUES(null,:name,:sectionid,:main,:templateid)");
      $dbParams = array('name'=>$page_name,'sectionid'=>$section_id,'main'=>$main,'templateid'=>$template);
      $dbQuery->execute($dbParams);

      header("Location: ?success=pagecreated");
    }
  }

  if (isset($_GET['action'])) {
    if ($_GET['action'] == "add") {
      $section_id = $_GET['sid'];

      $dbQuery=$db->prepare("SELECT id, name FROM `templates`");
      $dbQuery->execute();

      while ($dbRow = $dbQuery->fetch(PDO::FETCH_ASSOC))
      {
        $template_id = $dbRow["id"];
        $template_name = $dbRow["name"];

        $template_data = array (
          'template_id' => $template_id,
          'template_name' => $template_name
        );

        $data['add_page']['templates'][] = $template_data;
      }

      $data['add_page']['section_id'] = $section_id;
    }
  }
  else {

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
        $main_page = $dbRowContent["main"];

        if (!$main_page) {
          $content_id = $dbRowContent["id"];
          $content_name = $dbRowContent["name"];

          $content_data = array(
            'content_id' => $content_id,
            'content_name' => $content_name
          );

          $section_data['content_manage'][] = $content_data;
        }
      }

      $data['sections_manage'][] = $section_data;
    }
  }

  print_r($data);

  //echo $m->render($template, $data);