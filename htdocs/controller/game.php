<?php

  before_action("check_entry", array("show", "skip", "turn"), array("model_name" => "game"));
  before_action("create_form", array("new", "create"), "new_game");
  before_action("check_form", array("create"), "new_game");
  before_action("create_form", array("show", "turn"), "turn");
  before_action("check_form", array("turn"), "turn");

  switch ($_GET["action"]) {

  case "index":
    break;

  case "new":
    break;

  case "create":
    $game["id"] = create_game();
    $_SESSION["game"] = $game["id"];
    foreach ($_POST["cards_suspect"] as $suspect => $cards) {
      create_player($suspect, $cards);
    }
    foreach ($_POST["known_cards"] as $card) {
      add_card_owner_status($card, $_POST["identity"], owned);
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
    $_SESSION["game"] = $game["id"];
    break;

  default:
    header_if(true, 403);
    exit;
  }
