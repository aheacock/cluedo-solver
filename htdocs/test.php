<?php

  include "global/initialisation.php";

  var_dump(select_with_request_string(
    "status",
    "owned",
    array("game", "player", "card", "status"),
    array(),
    array("game" => 2, "player" => 3, "card" => 14)
  ));
