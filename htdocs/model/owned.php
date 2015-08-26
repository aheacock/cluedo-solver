<?php

  function add_card_owner_status($id, $player, $status) {
    $values["player"] = $player;
    $values["id"] = $id;
    $values["game"] = $_SESSION["game"];
    $values["status"] = $status;
    return create_entry(
      "owned",
      array("id", "game", "player", "status"),
      array(),
      $values
    );
  }
