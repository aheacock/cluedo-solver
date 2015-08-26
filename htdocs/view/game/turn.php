<?php echo form_input(pretty_card(array("id" => $_SESSION["current_player"]))." suspecte", "suspect", $form, array("options" => option_array(select_suspects(), "id", "name", "card"))); ?>
<?php echo form_input("avec l'arme", "weapon", $form, array("options" => option_array(select_weapons(), "id", "name", "card"))); ?>
<?php echo form_input("dans la pièce", "room", $form, array("options" => option_array(select_rooms(), "id", "name", "card"))); ?>
<?php echo form_input("mais le témoin", "witness", $form, array("options" => option_array(select_suspects(), "id", "name", "card"))); ?>
<?php echo form_input("réfute avec", "evidence", $form, array("options" => option_array(select_types(), "id", "name", "type"))); ?>.

<?php echo form_submit_button("Ok"); ?>
