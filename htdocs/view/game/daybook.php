<h1>Déroulé de la partie</h1>
<?php echo link_to(path("show", "game", game), "Retour", array("class" => "btn btn-primary")); ?>
<table class="table table-bordered table-hover table-small-char">
  <thead>
    <tr>
      <th>Suspect</th>
      <th>Arme</th>
      <th>Salle</th>
      <th>Demandé par</th>
      <th>Montré par</th>
      <th>Preuve</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach (select_turns() as $turn) {
      $turn = select_turn($turn["id"], array("id", "suspect", "weapon", "room", "player", "witness", "evidence"));
      ?>
      <tr>
        <td>
          <?php echo pretty_card(array("id" => $turn["suspect"])); ?>
        </td>
        <td>
          <?php echo pretty_card(array("id" => $turn["weapon"])); ?>
        </td>
        <td>
          <?php echo pretty_card(array("id" => $turn["room"])); ?>
        </td>
        <td>
          <?php echo pretty_card(array("id" => $turn["player"])); ?>
        </td>
        <td>
          <?php
          if (!is_empty($turn["witness"])) {
            echo pretty_card(array("id" => $turn["witness"]));
          }
          ?>
        </td>
        <td>
          <?php
          if (!is_empty($turn["evidence"])) {
            echo pretty_type(array("id" => $turn["evidence"]));
          }
          ?>
        </td>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>
<?php echo link_to(path("show", "game", game), "Retour", array("class" => "btn btn-primary")); ?>
