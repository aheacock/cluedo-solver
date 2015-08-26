<?php

  function add_card_owner($player, $type, $id) {
    $values["player"] = $player;
    $values["type"] = $type;
    $values["id"] = $id;
    $values["game"] = $_SESSION["game"];
    return create_entry(
      "card",
      array("id", "type", "game", "player"),
      array(),
      $values
    );
  }
