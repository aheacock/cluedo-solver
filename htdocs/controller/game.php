<?php

  switch ($_GET["action"]) {

  case "index":
    break;

  case "new":
    break;

  case "create":
    break;

  case "turn":
    redirect_to_action("show");
    break;

  case "skip":
    redirect_to_action("show");
    break;

  case "show":
    break;

  default:
    header_if(true, 403);
    exit;
  }
