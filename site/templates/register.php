<?php snippet('header') ?>

<h1><?= $page->title()->html() ?></h1>
<br>
<?php if($error): ?>
<div class="alert"><?= $page->alert()->html() ?></div>
<?php endif ?>

<form method="post" action="<?= $page->url() ?>">
  <div>
    <input type="email" id="email" name="email" placeholder="<?= $page->username()->html() ?>" value="<?= esc(get('email')) ?>" required>
  </div>
  <br>
  <div>
    <input type="password" id="password" name="password" placeholder="<?= $page->password()->html() ?>" value="<?= esc(get('password')) ?>" required>
  </div>
  <br>
  <div>
    <?php 
      $i = rand(0,25);
      $j = rand(0,10);  
      $r = $i+$j;  
    ?>
    <input type="number" id="captcha" name="captcha" placeholder="<?= $i ?> + <?= $j ?> =" value="" autocomplete="off" required>
    <input type="hidden" name="captcha_solution" value="<?= $r ?>" autocomplete="off" readonly>
  </div>
  <br>
  <div>
    <input type="submit" id="submit" name="register" value="<?= $page->button()->html() ?>">
  </div>
</form>

<?php snippet('footer') ?>