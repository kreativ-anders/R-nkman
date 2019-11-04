<?php
/**
 * Templates render the content of your pages. 
 * They contain the markup together with some control structures like loops or if-statements.
 * The `$page` variable always refers to the currently active page. 
 * To fetch the content from each field we call the field name as a method on the `$page` object, e.g. `$page->title()`. * 
 * This default template must not be removed. It is used whenever Kirby cannot find a template with the name of the content file.
 * Snippets like the header, footer and intro contain markup used in multiple templates. They also help to keep templates clean.
 * More about templates: https://getkirby.com/docs/guide/templates/basics
 */
?>
<?php snippet('header') ?>

<main>
  <?php snippet('intro') ?>

  <div class="text">
    <?= $page->text()->kt() ?>
  </div>

    <pre>
  <?php 

      //dump(Cookie::get('p'));
      //dump(count($ranking));
  ?>
  </pre>
  

<form action="" method="post">
  
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
