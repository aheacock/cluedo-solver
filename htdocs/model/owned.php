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
