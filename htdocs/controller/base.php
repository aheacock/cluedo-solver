<?php

  header_if(!validate_input(array("action", "controller"), array("tags")), 400);

  $full_controller = $_GET["controller"];
  header_if(!in_array($full_controller, array("game")), 404);

  $query_array = compute_query_array();

  if ($_GET["controller"] != "error") {
    include CONTROLLER_PATH.(isset($_GET["prefix"]) ? $_GET["prefix"]."/base.php" : $_GET["controller"].".php");
  } else {
    header_if($_GET["action"] == "unknown_url", 400);
  }

  if (!(STATE == "development" && ob_get_length() != 0)) {
    include LAYOUT_PATH."application.php";
  }
