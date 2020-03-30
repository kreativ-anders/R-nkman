<?php snippet('header') ?>

<h1><?= $page->title()->html() ?></h1>
<br>
<?php if($error): ?>
<div class="alert"><?= $page->alert()->html() ?></div>
<?php endif ?>

<form method="post" action="<?= $page->url() ?>">
  <div>
    <input type="email" id="email" name="email" placeholder="<?= $page->username()->html() ?>" value="<?= esc(get('email')) ?>">
  </div>
  <br>
  <div>
    <input type="password" id="password" name="password" placeholder="<?= $page->password()->html() ?>" value="<?= esc(get('password')) ?>">
  </div>
  <br>
  <div>
    <input type="submit" id="submit" name="login" value="<?= $page->button()->html() ?>">
  </div>
</form>

<?php snippet('footer') ?>