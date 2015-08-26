<?php

  function create_turn($values) {
    $values["player"] = $_SESSION["current_player"];
    $values["game"] = $_SESSION["game"];
    return create_entry(
      "turn",
      array("player", "room", "weapon", "suspect", "witness", "testimony", "game"),
      array(),
      $values
    );
  }

  function select_turn($turn, $fields = array()) {
    $turn = select_entry(
      "turn",
      array("id", "player", "room", "weapon", "suspect", "witness", "testimony", "game"),
      $turn,
      $fields
    );
    return $turn;
  }

  function exists_turn($turn) {
    return select_turn($turn) ? true : false;
  }

  function select_turns($criteria = array(), $order_by = "", $ascending = true) {
    return select_entries(
      "turn",
      array("id", "player", "room", "weapon", "suspect", "witness", "testimony", "game"),
      array(),
      array(),
      $criteria,
      $order_by,
      $ascending
    );
  }

  function next_player($player) {
    $players = array_of_ids(select_suspects());
    if ($player == max($players)) {
      return min($players);
    }
    return $player + 1;
  }

  function increment_turn() {
    $_SESSION["current_player"] = next_player($_SESSION["current_player"]);
  }

  function players_between($detective, $witness) {
    $players_between = array();
    $player = next_player($detective);
    while ($player != $witness) {
      $players_between[] = $player;
      $player = next_player($player);
    }
    return $players_between;
  }
