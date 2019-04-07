<?php
  session_start();
  
  global $CFG;

  include($CFG->dirroot.'/config.php');
  include($CFG->dirroot.'/lib.php');

  require_once($CFG->dirroot.'/vendor/autoload.php');

  $m = new Mustache_Engine;

  $template = file_get_contents($CFG->dirroot.'/templates/admin/section.mustache');

  if (isset($_POST["name"])) {
    $section = $_POST["name"];
    
    $dbQuery=$db->prepare("SELECT position FROM `sections` ORDER BY position DESC");
    $dbQuery->execute();
    $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);

    $position = ($dbRow["position"]+1);

    $dbQuery=$db->prepare("INSERT INTO `sections` VALUES(null,:name,:position)");
    $dbParams = array('name'=>$section,'position'=>$position);
    $dbQuery->execute($dbParams);

    header("Location: ?success=created");
  }
  else if (isset($_GET["action"])) {
    $section_id = $_GET["sid"];

    // Get the section's id
    $dbQuery=$db->prepare("SELECT position FROM `sections` WHERE id = :id");
    $dbParams = array('id'=>$section_id);
    $dbQuery->execute($dbParams);
    $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);

    $existing_pos = $dbRow["position"];

    if ($_GET["action"] == "up") {
      // Define the new position
      $new_pos = ($existing_pos - 1);

      // Get the section currently in the new position
      $dbQuery=$db->prepare("SELECT id FROM `sections` WHERE position = :newpos");
      $dbParams = array('newpos'=>$new_pos);
      $dbQuery->execute($dbParams);
      $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);

      $other_section = $dbRow["id"];

      // Move section to new position
      $dbQuery=$db->prepare("UPDATE `sections` SET position = :newpos WHERE id = :id");
      $dbParams = array('id'=>$section_id,'newpos'=>$new_pos);
      $dbQuery->execute($dbParams);

      // Move section that lived in the new position to the now unoccupied old position
      $dbQuery=$db->prepare("UPDATE `sections` SET position = :oldpos WHERE id = :id");
      $dbParams = array('id'=>$other_section,'oldpos'=>$existing_pos);
      $dbQuery->execute($dbParams);

      header("Location: ?success=up");
    }
    else if ($_GET["action"] == "down") {
      // Define the new position
      $new_pos = ($existing_pos + 1);

      // Get the section currently in the new position
      $dbQuery=$db->prepare("SELECT id FROM `sections` WHERE position = :newpos");
      $dbParams = array('newpos'=>$new_pos);
      $dbQuery->execute($dbParams);
      $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);

      $other_section = $dbRow["id"];
      
      // Move section to new position
      $dbQuery=$db->prepare("UPDATE `sections` SET position = :newpos WHERE id = :id");
      $dbParams = array('id'=>$section_id,'newpos'=>$new_pos);
      $dbQuery->execute($dbParams);

      // Move section that lived in the new position to the now unoccupied old position
      $dbQuery=$db->prepare("UPDATE `sections` SET position = :oldpos WHERE id = :id");
      $dbParams = array('id'=>$other_section,'oldpos'=>$existing_pos);
      $dbQuery->execute($dbParams);

      header("Location: ?success=down");
    }
    else if ($_GET["action"] == "delete") {
      $sections = array();
      $position = 1;

      // Delete the position
      $dbQuery=$db->prepare("DELETE FROM `sections` WHERE id = :id");
      $dbParams = array('id'=>$section_id);
      $dbQuery->execute($dbParams);

      // Get sections in order of position
      $dbQuery=$db->prepare("SELECT id FROM `sections` ORDER BY `position` ASC");
      $dbQuery->execute();
      while ($dbRow = $dbQuery->fetch(PDO::FETCH_ASSOC))
      {
        array_push($sections, $dbRow["id"]);
      }

      // Loop through sections in order of position
      // Refactor positions following deleted element
      foreach ($sections as $section) {

        $dbQuery=$db->prepare("UPDATE `sections` SET position = :position WHERE id = :id");
        $dbParams = array('id'=>$section,'position'=>$position);
        $dbQuery->execute($dbParams);

        $position++;
      }

      header("Location: ?success=deleted");
    }
  }

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

    $data['sections_manage'][] = $section_data;
  }

  echo $m->render($template, $data);