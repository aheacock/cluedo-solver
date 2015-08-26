<?php

  function create_player($player, $cards) {
    $values["player"] = $player;
    $values["cards"] = $cards;
    $values["game"] = $_SESSION["game"];
    return create_entry(
      "player",
      array("id", "cards", "game"),
      array(),
      $values
    );
  }

  function select_player($player, $fields = array()) {
    $player = select_entry(
      "player",
      array("id", "cards", "game"),
      $player,
      $fields
    );
    return $player;
  }

  function select_players($criteria, $order_by = NULL, $ascending = true) {
    return select_entries(
      "player",
      array("id", "cards", "game"),
      array(),
      array(),
      $criteria,
      $order_by,
      $ascending
    );
  }
