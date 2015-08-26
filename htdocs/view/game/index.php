<h1>Parties existantes</h1>
<ul>
  <?php
  foreach (select_games() as $game) {
    ?>
    <li><?php echo pretty_game($game["id"]); ?></li>
    <?php
  }
  ?>
</ul>
<?php echo link_to(path("new", "game"), "Nouvelle partie", array("class" => "btn btn-primary")); ?>
