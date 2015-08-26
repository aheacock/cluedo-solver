<?php echo pretty_card($_SESSION["current_player"]); ?>
suspecte
<?php echo form_input("", "suspect", $form, array("options" => option_array(select_suspects(), "id", "name", "card"))); ?>
avec l'arme
<?php echo form_input("", "weapon", $form, array("options" => option_array(select_weapons(), "id", "name", "card"))); ?>
dans la pièce
<?php echo form_input("", "room", $form, array("options" => option_array(select_rooms(), "id", "name", "card"))); ?>,
mais le témoin
<?php echo form_input("", "witness", $form, array("options" => option_array(select_suspects(), "id", "name", "card"))); ?>
réfute avec
<?php echo form_input("", "evidence", $form, array("options" => option_array(select_types(), "id", "name", "type"))); ?>.

<?php echo form_submit_button("Ok"); ?>
