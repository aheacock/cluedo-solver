<?php

  function create_player($player, $cards) {
    $values["player"] = $player;
    $values["cards"] = $cards;
    $values["game"] = $_SESSION["game"];
    return create_entry(
      "player",
      array("player", "cards", "game"),
      array(),
      $values
    );
  }

  function select_cards_player($player) {
    $player = select_with_request_string(
      "cards",
      "player",
      array("player", "cards", "game"),
      array(),
      array("game" => $_SESSION["game"], "player" => $player)
    );
    if (!is_empty($player[0]["cards"])) {
      return $player[0]["cards"];
    }
    return 0;
  }

  function select_players($criteria = array(), $order_by = NULL, $ascending = true) {
    set_if_not_set($criteria["game"], $_SESSION["game"]);
    return select_with_request_string(
      "player as id",
      "player",
      array("player", "cards", "game"),
      array(),
      $criteria,
      $order_by,
      $ascending
    );
  }

  function next_player($player) {
    $players = array_of_ids(select_players());
    foreach ($players as $i => $p) {
      if ($p == $player) {
        $index = $i;
      }
    }
    set_if_exists($next_player, $players[$index + 1]);
    set_if_not_set($next_player, $players[0]);
    return $next_player;
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
