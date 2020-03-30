<?php snippet('header') ?>

<main>
  <?php snippet('intro') ?>

  <div class="text">
    <?= $page->text()->kt() ?>
  </div>

<form style="margin:auto;" action="" method="post">
  
  <label for="nickname" >
    <input type="text" id="nickname" name="nickname" value="<?php echo Cookie::get('n', null); ?>" placeholder="Nickname" required />
    <span style="font-size: 1.4em;font-weight: normal;color: #454545;">&nbsp;is my Nickname 💪 </span>
  </label>

  <br><br>

  <ul id="sortable">
  <?php foreach ($ranking as $position): ?>
    <li class="ui-state-default rankman-option"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
    <input name="ranking[]" value="<?php echo $position->ID ?>" hidden />
    <input name="description[]" value="<?php echo $position->Description ?>" hidden /><?php echo $position->Description ?></li>
  <?php endforeach ?>
  </ul>

  <br><br>

  <input id="submit" type="submit" value="I Choose You! 🐱" /> 
</form>
  


</main>

<?php snippet('footer') ?>
