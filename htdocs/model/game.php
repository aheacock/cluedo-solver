<?php

function create_game($my_player) {
  return create_entry(
    "game",
    array("date", "my_player"),
    array(),
    array("date" => current_date(), "my_player" => $my_player)
  );
}

function select_game($game, $fields = array()) {
  $game = select_entry(
    "game",
    array("date", "id", "my_player"),
    $game,
    $fields
  );
  return $game;
}

function select_games($criteria = array(), $order_by = NULL, $ascending = true) {
  return select_entries(
    "game",
    array("id", "date", "my_player"),
    array(),
    array(),
    $criteria,
    $order_by,
    $ascending
  );
}

function my_player() {
  return select_game($_SESSION["game"], array("my_player"))["my_player"];
}
