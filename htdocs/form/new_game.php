<?php

  $form["redirect_to_if_error"] = path("new", "game");
  $form["destination_path"] = path("create", "game");
  $form["html_form_path"] = VIEW_PATH."game/new_form.php";

  foreach (select_suspects() as $suspect) {
    $form["fields"]["cards_suspect_".$suspect["id"]] = create_quantity_field("le nombre de cartes de ".pretty_suspect($suspect["id"]), dealed_card_number, array("optional" => 1));
  }
  $form["fields"]["known_cards"] = create_id_field("mes cartes", "card", array("multiple" => 1, "optional" => 1));
  $form["fields"]["identity"] = create_id_field("mon identité", "card");

  function check_total_card_number($input) {
    $sum = 0;
    foreach ($input as $name => $value) {
      if (substr($name, 0, 14) == "cards_suspect_") {
        $sum += $value;
      }
    }
    if ($sum != dealed_card_number) {
      return "La somme des cartes ne fait pas ".dealed_card_number.".";
    }
    return "";
  }

  function check_known_cards_matches($input) {
    if ($input["cards_suspect_".$input["identity"][0]] != count($input["known_cards"])) {
      return "Il faut indiquer ".$input["cards_suspect_".$input["identity"]]." cartes connues.";
    }
    return "";
  }

  $form["validations"] = array("check_total_card_number", "check_known_cards_matches");

  function structured_cards_suspect_maker($validated_input) {
    $structured_input["cards_suspect"] = array();
    foreach ($validated_input as $name => $value) {
      $matched_groups = array();
      if (preg_match("/^cards_suspect_([0-9]*)$/", $name, $matched_groups)) {
        $structured_input["cards_suspect"][$matched_groups[1]] = $value;
      } else {
        $structured_input[$name] = $value;
      }
    }
    return $structured_input;
  }

  $form["structured_input_maker"] = "structured_cards_suspect_maker";
