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
    $game["id"] = create_game($_POST["identity"]);
    $_SESSION["game"] = $game["id"];
    foreach ($_POST["cards_suspect"] as $suspect => $cards) {
      create_player($suspect, $cards);
    }
    foreach ($_POST["known_cards"] as $card) {
      add_card_owner_status($card, $_POST["identity"], owned);
    }
    $_SESSION["current_player"] = select_suspects()[0]["id"];
    redirect_to_action("show");
    break;

  case "turn":
    create_turn($_POST);
    set_if_not_set($_POST["witness"], $_SESSION["current_player"]);
    foreach (players_between($_SESSION["current_player"], $_POST["witness"]) as $player) {
      add_card_owner_status($_POST["weapon"], $player, not_owned);
      add_card_owner_status($_POST["room"], $player, not_owned);
      add_card_owner_status($_POST["suspect"], $player, not_owned);
    }
    if (!is_empty($_POST["evidence"])) {
      switch ($_POST["evidence"]) {
        case room:
          add_card_owner_status($_POST["room"], $_POST["witness"], owned);
          break;
        case weapon:
          add_card_owner_status($_POST["weapon"], $_POST["witness"], owned);
          break;
        case suspect:
          add_card_owner_status($_POST["suspect"], $_POST["witness"], owned);
          break;
      }
    }
    increment_turn();
    redirect_to_action("show");
    break;

  case "skip":
    increment_turn();
    redirect_to_action("show");
    break;

  case "show":
    $_SESSION["game"] = $game["id"];
    break;

  default:
    header_if(true, 403);
    exit;
  }
