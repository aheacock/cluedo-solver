<?php

  before_action("check_entry", array("show", "skip", "turn", "daybook", "revert"), array("model_name" => "game"));
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
    define("game", create_game($_POST["identity"]));
    define("turn", -1);
    foreach ($_POST["cards_suspect"] as $suspect => $cards) {
      create_player($suspect, $cards);
    }
    foreach ($_POST["known_cards"] as $card) {
      add_card_owner_status($card, $_POST["identity"], owned);
    }
    foreach (select_suspects() as $player) {
      if (select_cards_player($player["id"]) == 0) {
        foreach (select_cards() as $card) {
          add_card_owner_status($card["id"], $player["id"], not_owned);
        }
      }
    }
    $game["id"] = game;
    redirect_to_action("show");
    break;

  case "turn":
    define("turn", create_turn($_POST));
    set_if_not_set($_POST["witness"], get_current_player());
    foreach (players_between(get_current_player(), $_POST["witness"]) as $player) {
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
    if (get_status($_POST["room"], $_POST["witness"]) == not_owned && get_status($_POST["weapon"], $_POST["witness"]) == not_owned) {
      add_card_owner_status($_POST["suspect"], $_POST["witness"], owned);
    } elseif (get_status($_POST["weapon"], $_POST["witness"]) == not_owned && get_status($_POST["suspect"], $_POST["witness"]) == not_owned) {
      add_card_owner_status($_POST["room"], $_POST["witness"], owned);
    } elseif (get_status($_POST["room"], $_POST["witness"]) == not_owned && get_status($_POST["suspect"], $_POST["witness"]) == not_owned) {
      add_card_owner_status($_POST["weapon"], $_POST["witness"], owned);
    }
    increment_turn();
    redirect_to_action("show");
    break;

  case "skip":
    increment_turn();
    redirect_to_action("show");
    break;

  case "show":
    break;

  case "daybook":
    break;

  case "revert":
    $turn = max(array_of_ids(select_turns()));
    delete_turn($turn);
    delete_owned_of_turn($turn);
    redirect_to_action("show");
    break;

  default:
    header_if(true, 403);
    exit;
  }
