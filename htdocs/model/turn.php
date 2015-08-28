<?php

  function create_turn($values) {
    $values["player"] = get_current_player();
    $values["game"] = game;
    return create_entry(
      "turn",
      array("player", "room", "weapon", "suspect", "witness", "evidence", "game"),
      array(),
      $values
    );
  }

  function select_turn($turn, $fields = array()) {
    $turn = select_entry(
      "turn",
      array("id", "player", "room", "weapon", "suspect", "witness", "evidence", "game"),
      $turn,
      $fields
    );
    return $turn;
  }

  function exists_turn($turn) {
    return select_turn($turn) ? true : false;
  }

  function select_turns($criteria = array(), $order_by = "", $ascending = true) {
    set_if_not_set($criteria["game"], game);
    return select_entries(
      "turn",
      array("id", "player", "room", "weapon", "suspect", "witness", "evidence", "game"),
      array(),
      array(),
      $criteria,
      $order_by,
      $ascending
    );
  }

  function delete_turn($turn) {
    delete_entry("turn", $turn);
  }
