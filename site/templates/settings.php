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
      //dump(count($ranking));
  ?>
  </pre>
  
  <h2>Voters:</h2>
  <?= $page->voters()->kt() ?>

  <br><br>

  <?php  
    /*$u = Db::min('user', 'ID', 'Identifier="'. Cookie::get('u') . '"');

    $users = Db::select('voter', '*', ['User' => $u]);

    foreach ($users as $user) {
      echo $user->Description();
    }

    echo get('vid');*/

  ?>

  
  <?php foreach ($voters as $voter): ?>
  
    <li class="voter-option" style="margin: 5px 0px 5px 0px">
      <form action="" method="post">
        <input style="font-size: 1.4em;font-weight: normal;color: #454545;" class="voter" value="<?php echo $voter->Description ?>" readonly/>
        <input class="submit" type="submit" value="Delete" />

        <?php 
          $link = '/rankman/survey/' . $kirby->user()->id() . '/' . $voter->Identifier;
        ?>
      
        <a href="<?php echo $link ?>"><?php echo $voter->Description ?> specific survey link</a>
      </form>
    </li> 
 
  <?php endforeach ?>

  <form action="" method="post">
    <input style="font-size: 1.4em;font-weight: normal;color: #454545;" class="voter" name="voter" value="" />
    <input class="submit" type="submit" value="Add Voter" /> 
  </form>

  <br><br>

  <h2>Options:</h2>
  <?= $page->options()->kt() ?>

  <br><br>

  <?php foreach ($options as $option): ?>
  
    <li class="option" style="margin: 5px 0px 5px 0px">
      <form action="" method="post">
        <input style="font-size: 1.4em;font-weight: normal;color: #454545;" class="option" value="<?php echo $option->Description ?>" readonly/>

        <?php 
          $owner = Db::min('voter', 'Description', ['ID' => $option->Owner]);
        ?>

        <input class="voter" value="<?php echo $owner ?>" readonly/>
        <input class="submit" type="submit" value="Delete" />
      
      </form>
    </li> 
 
  <?php endforeach ?>

  <form action="" method="post">
    <input style="font-size: 1.4em;font-weight: normal;color: #454545;" class="option" name="option" value="" />
    <select name="owner" id="owner" style="width: 17.65rem">
    <?php foreach ($voters as $voter): ?>

      <option value="<?php echo $voter->Identifier ?>"><?php echo $voter->Description ?></option>

    <?php endforeach ?>
    </select>
    <input class="submit" type="submit" value="Add Voter" /> 
  </form>

  <br><br>

</main>

<?php snippet('footer') ?>
