<?php

  function pretty_amount($amount, $sign = true, $symbol = false) {
    $amount *= 1/100;
    $symbol = $symbol ? "<i class=\"fa fa-fw fa-euro\"></i>" : "";
    if ($sign) {
      return ($amount > 0 ? "+" : "").$amount.$symbol;
    } else {
      return ($amount > 0 ? $amount : -$amount).$symbol;
    }
  }

  function pretty_date($date) {
    return ($date != "0000-00-00") ? strftime("%d/%m/%Y",strtotime($date)) : "" ;
  }

  function pretty_suspect($suspect) {
    return select_card($suspect, array("name"))["name"];
  }

  function pretty_game($game) {
    return link_to(path("show", "game", $game["id"]), pretty_date(select_game($game["id"], array("date"))["date"]));
  }
