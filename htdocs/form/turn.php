<?php

  $form["redirect_to_if_error"] = path("show", "game");
  $form["destination_path"] = path("turn", "game");
  $form["html_form_path"] = VIEW_PATH."game/turn.php";

  $form["fields"]["room"] = create_id_field("la salle", "card");
  $form["fields"]["suspect"] = create_id_field("le suspect", "card");
  $form["fields"]["weapon"] = create_id_field("l'arme", "card");
  $form["fields"]["witness"] = create_id_field("le témoin", "card");
  $form["fields"]["evidence"] = create_id_field("la preuve", "type");
