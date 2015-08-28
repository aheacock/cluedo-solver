<?php
echo get_html_form("turn");

$status_to_class = array(
  owned => "red",
  very_likely => "orange",
  likely => "yellow",
  unknown => "white",
  not_owned => "black"
);
?>

<h1>Armes</h1>
<table class="table table-bordered table-hover table-small-char">
  <thead>
    <tr>
      <th></th>
      <?php
      foreach (select_players() as $player) {
        echo "<th>".pretty_card($player)."</th>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach (select_weapons() as $weapon) {
      ?>
      <tr>
        <td><?php echo pretty_card($weapon); ?></td>
        <?php
        foreach (select_players() as $player) {
          $class = "status-".$status_to_class[get_status($weapon["id"], $player["id"])];
          ?>
          <td class="<?php echo $class; ?>"></td>
          <?php
        }
        ?>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>

<h1>Suspects</h1>
<table class="table table-bordered table-hover table-small-char">
  <thead>
    <tr>
      <th></th>
      <?php
      foreach (select_players() as $player) {
        echo "<th>".pretty_card($player)."</th>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach (select_suspects() as $suspect) {
      ?>
      <tr>
        <td><?php echo pretty_card($suspect); ?></td>
        <?php
        foreach (select_players() as $player) {
          $class = "status-".$status_to_class[get_status($suspect["id"], $player["id"])];
          ?>
          <td class="<?php echo $class; ?>"></td>
          <?php
        }
        ?>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>

<h1>Salles</h1>
<table class="table table-bordered table-hover table-small-char">
  <thead>
    <tr>
      <th></th>
      <?php
      foreach (select_players() as $player) {
        echo "<th>".pretty_card($player)."</th>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach (select_rooms() as $room) {
      ?>
      <tr>
        <td><?php echo pretty_card($room); ?></td>
        <?php
        foreach (select_players() as $player) {
          $class = "status-".$status_to_class[get_status($room["id"], $player["id"])];
          ?>
          <td class="<?php echo $class; ?>"></td>
          <?php
        }
        ?>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>

<h1>Non résolus</h1>

<?php
foreach (select_players() as $player) {
  $remaining_cards = select_cards_player($player["id"]) - count(known_cards_player($player["id"]));
  if ($remaining_cards > 0) {
    ?>
    <h2><?php echo pretty_card($player)." (".$remaining_cards.")"; ?></h2>
    <table class="table table-bordered table-hover table-small-char">
      <tbody>
        <?php
        foreach (select_turns() as $turn) {
          $turn = select_turn($turn["id"], array("id", "weapon", "room", "suspect", "witness"));
          if (!is_empty($turn["witness"]) && $player["id"] == $turn["witness"]) {
            $status_weapon = get_status($turn["weapon"], $turn["witness"]);
            $status_room = get_status($turn["room"], $turn["witness"]);
            $status_suspect = get_status($turn["suspect"], $turn["witness"]);
            if ($status_weapon != owned && $status_room != owned && $status_suspect != owned) {
              ?>
              <tr>
                <td>
                  <?php
                  if ($status_weapon != not_owned) {
                    echo pretty_card(array("id" => $turn["weapon"]));
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if ($status_suspect != not_owned) {
                    echo pretty_card(array("id" => $turn["suspect"]));
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if ($status_room != not_owned) {
                    echo pretty_card(array("id" => $turn["room"]));
                  }
                  ?>
                </td>
              </tr>
              <?php
            }
          }
        }
        ?>
      </tbody>
    </table>
    <?php
  }
}
?>

<?php echo link_to(path("daybook", "game", $_SESSION["game"]), "Déroulé de la partie", array("class" => "btn btn-primary")); ?>
