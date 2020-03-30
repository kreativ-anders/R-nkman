<?php snippet('header') ?>

<main>
  <?php snippet('intro') ?>
 
  <h2>Voters:</h2>
  <?= $page->text()->kt() ?>

  <br><br>
  
  <?php foreach ($voters as $voter): ?>
  
    <li class="voter-option" style="margin: 5px 0px 5px 0px">
      <form action="" method="post">
        <input style="font-size: 1.4em;font-weight: normal;color: #454545;" class="voter" value="<?php echo $voter->Description ?>" readonly/>
        <input class="voter" type="hidden" name="vid" value="<?php echo md5($voter->Description) ?>" />
        <input class="submit" type="submit" value="Delete" />

        <?php 
          $link = '/survey/' . $kirby->user()->id() . '/' . $voter->Identifier;
        ?>
       
        <input type="text" style="width: 0px; border: none" value="<?php echo url($link) ?>" id="<?php echo $voter->Description ?>" />
        <span style="cursor: pointer" onclick="copyLink('<?php echo $voter->Description ?>')">Copy specific survey link for <?php echo $voter->Description ?></span>
      </form>
    </li> 
 
  <?php endforeach ?>

  <script>
  function copyLink(voter) {
    /* Get the text field */
    var copyText = document.getElementById(voter);

    /* Select the text field */
    copyText.select(); 
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");
  }
  </script>

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
        <input type="hidden" name="oid" value="<?php echo $option->Description ?>" />
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
    <input class="submit" type="submit" value="Add Option" /> 
  </form>

  <br><br>

</main>

<?php snippet('footer') ?>
