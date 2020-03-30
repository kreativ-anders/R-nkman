<?php snippet('header') ?>

<main>
  <?php snippet('intro') ?>

  <div class="text" style="color: red">
    <?= $page->text()->kt() ?>
  </div>
  
  <a href="dashboard/settings" style="text-decoration: underline; color: blue;">Survey Settings</a>

  <br><br>

  <h3>Participants:</h3>
  <ul style>
  <?php  
    $u = Db::min('user', 'ID', 'Identifier="'. $kirby->user() . '"');

    $users = Db::select('voter', '*', ['User' => $u]);

    foreach ($users as $user) {
      echo "<li style=\"display: inline-block; padding-right: 2rem;\">" . $user->Description() . "</li>";
    }

    echo get('vid');
  ?>
  </ul>
 
  <br><br>

  <table>
    <tr>
      <th style="padding-right: 2rem;">Rank</th>
      <th style="padding-right: 2rem;">Description</th>
      <th style="padding-right: 2rem;">Score</th>
    </tr>

    <?php foreach ($ranking as $i=>$position): ?>
    <tr>
      <td><?php echo $i+1 ?></td>
      <td><?php echo $position->Description ?></td>
      <td><?php echo $position->Score ?></td>
    </tr>
  <?php endforeach ?>

  </table>
  
  <br><br>

</main>

<?php snippet('footer') ?>
