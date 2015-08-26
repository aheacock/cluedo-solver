<?php
foreach (select_suspects() as $suspect) {
  echo form_input("Nombre de cartes de ".pretty_suspect($suspect["id"]), "cards_suspect_".$suspect["id"], $form);
}
echo form_input("Cartes que j'ai en ma possession :", "known_cards", $form, array("options" => option_array(select_cards(), "id", "name", "card")));
echo form_input("Mon identité :", "identity", $form, array("options" => option_array(select_suspects(), "id", "name", "card")));
echo form_submit_button("Démarer");
?>
