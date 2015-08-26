<?php

  function add_card_owner_status($card, $player, $status) {
    $values["player"] = $player;
    $values["card"] = $card;
    $values["game"] = $_SESSION["game"];
    $values["status"] = $status;
    create_entry(
      "owned",
      array("card", "game", "player", "status"),
      array(),
      $values
    );
    if ($status == owned) {
      foreach (select_suspects() as $other_player) {
        if ($other_player["id"] != $player) {
          add_card_owner_status($card, $other_player["id"], not_owned);
        }
      }
      $known_cards = known_cards_player($player);
      $_SESSION["notice"][] = array_to_string(select_cards(array("id" => array("NOT IN", $known_cards))));
      if (count($known_cards) == select_cards_player($player)) {
        foreach (select_cards(array("id" => array("NOT IN", $known_cards))) as $other_card) {
          add_card_owner_status($other_card, $player, not_owned);
        }
      }
    }
  }

  function get_status($card, $player) {
    $results = select_with_request_string(
      "status",
      "owned",
      array("game", "player", "card", "status"),
      array(),
      array("game" => $_SESSION["game"], "player" => $player, "card" => $card)
    );
    if (!is_empty($results)) {
      return $results[0]["status"];
    }
    return unknown;
  }

  function known_cards_player($player) {
    return array_of_ids(select_with_request_string(
      "card AS id",
      "owned",
      array("game", "player", "card", "status"),
      array(),
      array("game" => $_SESSION["game"], "player" => $player, "status" => owned)
    ));
  }
