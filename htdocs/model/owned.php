<?php

  function add_card_owner_status($card, $player, $status) {
    $values["player"] = $player;
    $values["card"] = $card;
    $values["game"] = $_SESSION["game"];
    $values["status"] = $status;
    return create_entry(
      "owned",
      array("card", "game", "player", "status"),
      array(),
      $values
    );
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
