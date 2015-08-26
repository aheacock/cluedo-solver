<?php

  function add_card_owner($player, $id) {
    $values["player"] = $player;
    $values["id"] = $id;
    $values["game"] = $_SESSION["game"];
    return create_entry(
      "owned",
      array("id", "game", "player"),
      array(),
      $values
    );
  }
