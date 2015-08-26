<?php

  if ($_SERVER["HTTP_HOST"] == "localhost:3000") {
    include "config/development.php";
  } else {
    include "config/production.php";
  }

  include "constants.php";
  session_start();
  date_default_timezone_set('Europe/Paris');
  setlocale(LC_TIME, "fr_fr");

  error_reporting(E_ALL);
  ini_set("display_errors", STATE == "development" ? "1" : "0");

  include GLOBAL_PATH."database.php";
  include GLOBAL_PATH."agregation.php";
  include GLOBAL_PATH."sql.php";
  include GLOBAL_PATH."routes.php";
  include GLOBAL_PATH."before_actions.php";
  include GLOBAL_PATH."common.php";
  include GLOBAL_PATH."csrf.php";
  include GLOBAL_PATH."email.php";
  include GLOBAL_PATH."form.php";

  include MODEL_PATH."card.php";
  include MODEL_PATH."player.php";
  include MODEL_PATH."turn.php";

  include HELPER_PATH."common.php";
  include HELPER_PATH."pretty_print.php";
  include HELPER_PATH."tag.php";
  include HELPER_PATH."sidebar.php";
  include HELPER_PATH."show.php";
  include HELPER_PATH."form.php";
  include HELPER_PATH."fuzzy_finder.php";
  include HELPER_PATH."state.php";
  include HELPER_PATH."common_js.php";
