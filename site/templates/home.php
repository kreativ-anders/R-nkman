<?php snippet('header') ?>

<?php 

  $ranking = array(
    array("ID" => 1, "Description" => "Create easy & fast"),
    array("ID" => 2, "Description" => "Ranking-Surveys"),
    array("ID" => 3, "Description" => "(even with specific participant groups!)"),
    array("ID" => 4, "Description" => "and send them via a specific link"),
    array("ID" => 5, "Description" => "BUT!!!"),
    array("ID" => 6, "Description" => "This is an early-early-beta-version 😅"),
    array("ID" => 7, "Description" => "Bugs may be present!"),
    array("ID" => 8, "Description" => "Not sure? Just register & try. 😏"),
  );

?>

<main>
  <?php snippet('intro') ?>

  <ul style="margin: auto" id="sortable">
  <?php foreach ($ranking as $position): ?>
    <li class="ui-state-default rankman-option"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
    <input name="ranking[]" value="<?php echo $position["ID"] ?>" hidden />
    <input name="description[]" value="<?php echo $position["Description"] ?>" hidden /><?php echo $position["Description"] ?></li>
  <?php endforeach ?>
  </ul>

</main>

<?php snippet('footer') ?>
