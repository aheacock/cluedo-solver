<?php

function select_type($type, $fields = array()) {
  $type = select_entry(
    "type",
    array("id", "name"),
    $type,
    $fields
  );
  return $type;
}

function exists_type($type) {
  return select_type($type) ? true : false;
}

function select_types($criteria = array(), $order_by = NULL, $ascending = true) {
  return select_entries(
    "type",
    array("id", "name"),
    array(),
    array(),
    $criteria,
    $order_by,
    $ascending
  );
}
