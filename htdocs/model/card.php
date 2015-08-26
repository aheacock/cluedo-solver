<?php

function select_card($card, $fields = array()) {
  $card = select_entry(
    "card",
    array("id", "name", "type"),
    $card,
    $fields
  );
  return $card;
}

function exists_card($card) {
  return select_card($card) ? true : false;
}

function select_cards($criteria = array(), $order_by = NULL, $ascending = true) {
  return select_entries(
    "card",
    array("id", "name", "type"),
    array(),
    array(),
    $criteria,
    $order_by,
    $ascending
  );
}

function select_suspects() {
  return select_cards(array("type" => suspect));
}

function select_weapons() {
  return select_cards(array("type" => weapon));
}

function select_rooms() {
  return select_cards(array("type" => room));
}
