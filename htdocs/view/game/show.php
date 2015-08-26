<?php
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
      foreach (select_suspects() as $player) {
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
        foreach (select_suspects() as $player) {
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
      foreach (select_suspects() as $player) {
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
        foreach (select_suspects() as $player) {
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
      foreach (select_suspects() as $player) {
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
        foreach (select_suspects() as $player) {
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
