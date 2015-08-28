<?php echo form_input(pretty_card(array("id" => $_SESSION["current_player"]))." suspecte", "suspect", $form, array("options" => option_array(select_suspects(), "id", "name", "card"))); ?>
<?php echo form_input("avec l'arme", "weapon", $form, array("options" => option_array(select_weapons(), "id", "name", "card"))); ?>
<?php echo form_input("dans la pièce", "room", $form, array("options" => option_array(select_rooms(), "id", "name", "card"))); ?>
<?php echo form_input("mais le témoin", "witness", $form, array("options" => array_true_merge(option_array(select_players(), "id", "name", "card"), array(0 => "")))); ?>
<?php
if ($_SESSION["current_player"] == my_player()) {
  echo form_input("réfute avec", "evidence", $form, array("options" => option_array(select_types(), "id", "name", "type")));
} else {
  echo "réfute";
}
?>.
<br>
<?php
$turns = select_turns();
echo
  form_submit_button("Ok") . " " .
  link_to(path("skip", "game", $_SESSION["game"]), "Suivant", array("class" => "btn btn-primary")) . " " .
  (!is_empty($turns) ? link_to(path("revert", "game", $_SESSION["game"]), "Annuler le dernier coup", array("class" => "btn btn-primary")) : "")
;
?>
