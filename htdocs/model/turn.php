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
    set_if_not_set($criteria["game"], $_SESSION["game"]);
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
