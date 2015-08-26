<?php

function create_game() {
  return create_entry(
    "game",
    array("date"),
    array(),
    array("date" => current_date())
  );
}

function select_game($game, $fields = array()) {
  $game = select_entry(
    "game",
    array("date", "id"),
    $game,
    $fields
  );
  return $game;
}

function select_games($criteria, $order_by = NULL, $ascending = true) {
  return select_entries(
    "game",
    array("id", "date"),
    array(),
    array(),
    $criteria,
    $order_by,
    $ascending
  );
}
