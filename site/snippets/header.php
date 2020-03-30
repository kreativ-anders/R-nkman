<?php
/**
 * Snippets are a great way to store code snippets for reuse or to keep your templates clean.
 * This header snippet is reused in all templates. 
 * It fetches information from the `site.txt` content file and contains the site navigation.
 * More about snippets: https://getkirby.com/docs/guide/templates/snippets
 */
?>

<!doctype html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <!-- The title tag we show the title of our site and the title of the current page -->
  <title><?= $site->title() ?> | <?= $page->title() ?></title>

  <!-- Stylesheets can be included using the `css()` helper. Kirby also provides the `js()` helper to include script file. 
        More Kirby helpers: https://getkirby.com/docs/reference/templates/helpers -->
  <?= css(['assets/css/index.css', '@auto']) ?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
  body { 
    counter-reset: myCounter VoterCounter; 
  } 
  .rankman-option::before { 
      counter-increment: myCounter; 
      content: "Rank " counter(myCounter) ": "; 
  } 
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 50px; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
   $( function() {
    $( "#sortable" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( "#sortable" ).disableSelection();
  } );
  </script>

</head>
<body>

  <div class="page">
    <header class="header">
      <!-- In this link we call `$site->url()` to create a link back to the homepage -->
      <a class="logo" href="<?= $site->url() ?>"><?= $site->title() ?></a>

      <nav id="menu" class="menu">
      <?php foreach ($site->children()->listed() as $item): ?>
        <?= $item->title()->link() ?>
      <?php endforeach ?>
      <?php if ($user = $kirby->user()): ?>
        <a href="<?= url('dashboard') ?>">Dashboard</a>
        <a href="<?= url('logout') ?>">Logout</a>
      <?php else: ?>
        <a href="register">Register</a>
        <a href="login">Login</a>
      <?php endif ?>
    </nav>
    </header>

