<?php

return function ($kirby) {

  if (!$kirby->user()) {
    go('/');
  }

  $vid = null;
  $voter = null;
  $voters = null;
  $options = null;
  $session = $kirby->session();
  $arr = array();

  $u = Db::min('user', 'ID', 'Identifier="'. $kirby->user() . '"');

  $voters = Db::select('voter', '*', ['User' => $u]);
  $options = Db::select('position', '*', ['User' => $u]);

  if ($kirby->request()->is('POST') && get('vid')) { 
    
    // DELETE VOTER
    $vid = get('vid');
    
    $bool = Db::delete('voter', ['Identifier' => $vid]);
    go('dashboard/settings');
  } 
  elseif ($kirby->request()->is('POST') && get('voter')) { 
    
    //INSERT VOTER
    $voter = get('voter');

    $id = Db::insert('voter', [
      'User'          => $u,
      'Description'   => $voter,
      'Identifier'    => md5($voter)
    ]);
    go('dashboard/settings');

  }
  elseif ($kirby->request()->is('POST') && get('oid')) { 
    
    // DELETE Option
    $oid = get('oid');

    
    $bool = Db::delete('position', ['Description' => $oid, 'User' => $u]);
    go('dashboard/settings');
  } 
  elseif ($kirby->request()->is('POST') && get('option') && get('owner')) { 
    
    //INSERT OPTION
    $option = get('option');
    $owner = Db::min('voter', 'ID', 'Identifier="'. get('owner') . '"');

    $id = Db::insert('position', [
      'User'          => $u,
      'Description'   => $option,
      'Owner'         => $owner
    ]);
    go('dashboard/settings');

  }
  else {

    $mysqli = new mysqli( option('db')["host"]
                         ,option('db')["user"]
                         ,option('db')["password"]
                         ,option('db')["database"]);

    $session = $kirby->session();

    $u = Db::min('user', 'ID', 'Identifier="'. Cookie::get('u') . '"');
    $v = Db::min('voter', 'ID', 'Identifier="'. Cookie::get('v') . '"');

    $session->set('u', $u); 
    $session->set('v', $v); 

    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

    $stmt =  $mysqli->stmt_init();

    if ($stmt->prepare("SELECT position.ID, position.Description FROM position WHERE position.User = ? AND position.Owner IN (SELECT voter.ID FROM voter WHERE voter.Identifier != ?)")) {

      /* bind parameters for markers */
      $u = $session->get('u');  
      $v = Cookie::get('v', null); 
      $stmt->bind_param("ss", $u, $v);

      /* execute query */
      $stmt->execute();

      /* bind result variables */
      $stmt->bind_result($IDs, $Descriptions);

      /* fetch value */
      $stmt->fetch();

      while ($stmt->fetch()) {
        $obj = array('ID' => $IDs, 'Description' => $Descriptions);
        array_push($arr, (array) $obj);
      }
    
    
      $arr = json_encode($arr);
      Cookie::set('p', $arr);
      $ranking = json_decode($arr);

      /* close statement */
      $stmt->close();
    }

    $mysqli->close();
  }

  // pass $articles and $pagination to the template
  return [
    'voters' => $voters,
    'options' => $options
  ];

};