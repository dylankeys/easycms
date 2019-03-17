<?php
  session_start();
  include("../config.php");
  include("../lib.php");
?>
<!doctype html>
<!-- EasyCMS -->
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pure and True Holistic Therapies offer homemade natural products as well as a variety of relaxing treatments. Come and join the community to learn more.">
    <meta name="keywords" content="Holistic,Therapies,Therapy,Aromatherapy,Relax,Homemade,Natural,Organic,Pure,True">
    <meta name="author" content="Angela Keys">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Pure & True | Holistic Therapies</title>

    <link rel="icon" href="../pix/favicon.gif" type="image/gif">

    <!-- EasyCMS CSS -->
    <link rel="stylesheet" type="text/css" href="../css/easycms.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bs-blog.css">

  </head>
  <body>
    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-4 pt-1">
            <a class="text-muted" href="#">Sign-up for updates</a>
          </div>
          <div class="col-4 text-center">
            <img class="logo" src="../pix/logo.png" alt="Pure and True Holistic Therapies logo" />
          </div>
          <div class="col-4 d-flex justify-content-end align-items-center">
            <a class="btn btn-sm btn-outline-secondary" href="#">Book now</a>
          </div>
        </div>
      </header>

      <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
          <?php
            $dbQuery=$db->prepare("SELECT `name` FROM `sections` ORDER BY `position` ASC");
            $dbParams = array('id'=>$userID);
            $dbQuery->execute($dbParams);
            //$dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);

            while ($dbRow = $dbQuery->fetch(PDO::FETCH_ASSOC))
            {
              $name=$dbRow["name"];

              echo '<a class="p-2 text-muted" href="'.lcfirst($name).'">'.$name.'</a>';
            }
          ?>
        </nav>
      </div>

      <div class="container">
     
        <br>
          <h1>Settings</h1>
     
        <div class="jumbotron jumbotron-fluid slideshow-right">
          <div class="container-jumbo">
            <h1 class="display-4">EasyCMS (alpha)</h1>
            <p class="lead">Version: 0.1</p>
          </div>
        </div>
     
        <div class="list-group slideshow-left">
          <a href="add/section/" class="list-group-item list-group-item-action">Add sections</a>
          <a href="add/page/" class="list-group-item list-group-item-action">Add pages</a>
        </div>
      </div>
    </div>

    <footer class="blog-footer footer">
      <p>&copy; <?php echo date('Y'); ?> Pure & True Holistics | Site powered by <a href="https://dylankeys.com">EasyCMS</a></p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <!-- Bootstrap JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
