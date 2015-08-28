<?php

  function add_card_owner_status($card, $player, $status) {
    if (get_status($card, $player) != $status) {
      $values["player"] = $player;
      $values["card"] = $card;
      $values["game"] = $_SESSION["game"];
      $values["turn"] = turn;
      $values["status"] = $status;
      create_entry(
        "owned",
        array("card", "game", "player", "status", "turn"),
        array(),
        $values
      );
      if ($status == owned) {
        foreach (select_suspects() as $other_player) {
          if ($other_player["id"] != $player) {
            add_card_owner_status($card, $other_player["id"], not_owned);
          }
        }
        $known_cards = known_cards_player($player);
        if (count($known_cards) == select_cards_player($player)) {
          foreach (select_cards(array("id" => array("NOT IN", $known_cards))) as $other_card) {
            add_card_owner_status($other_card["id"], $player, not_owned);
          }
        }
        $card_type = select_card($card, array("type"))["type"];
        $known_cards = known_cards_type($card_type);
        $all_typed_cards = array_of_ids(select_cards(array("type" => $card_type)));
        if (count($known_cards) + 1 == count($all_typed_cards)) {
          foreach (array_diff($all_typed_cards, $known_cards) as $left_out_card) {
            foreach (select_suspects() as $other_player) {
              add_card_owner_status($left_out_card, $other_player["id"], not_owned);
            }
          }
        }
      } elseif ($status == not_owned) {
        foreach (select_turns() as $turn) {
          $turn = select_turn($turn["id"], array("weapon", "room", "suspect", "witness"));
          if ($turn["witness"] == $player) {
            if (($turn["weapon"] == $card && get_status($turn["room"], $player) == not_owned) || ($turn["room"] == $card && get_status($turn["weapon"], $player) == not_owned)) {
              add_card_owner_status($turn["suspect"], $player, owned);
            } elseif (($turn["weapon"] == $card && get_status($turn["suspect"], $player) == not_owned) || ($turn["suspect"] == $card && get_status($turn["weapon"], $player) == not_owned)) {
              add_card_owner_status($turn["room"], $player, owned);
            } elseif (($turn["suspect"] == $card && get_status($turn["room"], $player) == not_owned) || ($turn["room"] == $card && get_status($turn["suspect"], $player) == not_owned)) {
              add_card_owner_status($turn["weapon"], $player, owned);
            }
          }
        }
      }
    }
  }

  function get_status($card, $player) {
    $results = select_with_request_string(
      "status",
      "owned",
      array("game", "player", "card", "status"),
      array(),
      array("game" => $_SESSION["game"], "player" => $player, "card" => $card)
    );
    if (!is_empty($results)) {
      return $results[0]["status"];
    }
    return unknown;
  }

  function known_cards_player($player) {
    return array_of_ids(select_with_request_string(
      "card AS id",
      "owned",
      array("game", "player", "card", "status"),
      array(),
      array("game" => $_SESSION["game"], "player" => $player, "status" => owned)
    ));
  }

  function known_cards_type($type) {
    return array_of_ids(select_with_request_string(
      "card AS id",
      "owned",
      array("game", "player", "card", "status"),
      array(),
      array("game" => $_SESSION["game"], "card" => array("IN", array_of_ids(select_cards(array("type" => $type)))), "status" => owned)
    ));
  }
  
  function delete_owned_of_turn($turn) {
    $sql = "DELETE FROM owned WHERE turn = :turn";
    $req = Database::get()->prepare($sql);
    $req->bindValue(':turn', $turn, PDO::PARAM_INT);
    $req->execute();
  }
