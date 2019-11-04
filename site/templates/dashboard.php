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

  <div class="text" style="color: red">
    <?= $page->text()->kt() ?>
  </div>

    <pre>
  <?php 

      //dump(Cookie::get('p'));
      dump($ranking);
  ?>
  </pre>
  
  <a href="dashboard/settings">See survey setting</a>

  <br><br>

  <?php  
    $u = Db::min('user', 'ID', 'Identifier="'. Cookie::get('u') . '"');

    $users = Db::select('voter', '*', ['User' => $u]);

    foreach ($users as $user) {
      echo $user->Description();
    }

    echo get('vid');

  ?>

  <br><br>

  <ul>
  <?php foreach ($ranking as $position): ?>
    <li class="rankman-option">
    <?php echo $position->Description ?>
    (<?php echo $position->Score ?>)
    </li>
  <?php endforeach ?>
  </ul>

  <br><br>



  


</main>

<?php snippet('footer') ?>
