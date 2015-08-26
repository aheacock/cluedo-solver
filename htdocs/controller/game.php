<?php

  before_action("create_form", array("new", "create"), "new_game");
  before_action("check_form", array("create"), "new_game");

  switch ($_GET["action"]) {

  case "index":
    break;

  case "new":
    break;

  case "create":
    foreach ($_POST["cards_suspect"] as $suspect => $cards) {
      create_player($suspect, $cards);
    }
    foreach ($_POST["known_cards"] as $card) {
      add_card_owner($_POST["identity"], $card);
    }
    redirect_to_action("show");
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
