<?php

  function create_turn($player, $room, $weapon, $suspect, $witness, $testimony) {
    $values["player"] = $player;
    $values["room"] = $room;
    $values["weapon"] = $weapon;
    $values["suspect"] = $suspect;
    $values["witness"] = $witness;
    $values["testimony"] = $testimony;
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
