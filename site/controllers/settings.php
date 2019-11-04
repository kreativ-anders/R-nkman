<?php

return function ($kirby) {

  $vid = null;
  $voter = null;
  $voters = null;
  $options = null;
  $session = $kirby->session();

  $u = Db::min('user', 'ID', 'Identifier="'. Cookie::get('u') . '"');

  $voters = Db::select('voter', '*', ['User' => $u]);
  $options = Db::select('position', '*', ['User' => $u]);

  if ($kirby->request()->is('POST') && get('vid')) { // DELETE
    $vid = get('vid');
    
    $bool = Db::delete('voter', ['Identifier' => $vid]);
    //dump($bool);
  } 
  elseif ($kirby->request()->is('POST') && get('voter')) { //INSERT
    $voter = get('voter');

    $u = $session->get('u');

    $id = Db::insert('voter', [
      'User'          => $u,
      'Description'  => $voter,
      'Identifier'    => md5($voter)
    ]);

  }
  elseif (!Cookie::exists('u')) {
    return go('/');
  }
  else {

    $mysqli = new mysqli("localhost", "rankman_db", "123456", "rankman");

    $session = $kirby->session();
    $u = Db::min('user', 'ID', 'Identifier="'. Cookie::get('u') . '"');
    $v = Db::min('voter', 'ID', 'Identifier="'. Cookie::get('v') . '"');
    $session->set('u', $u); 
    $session->set('v', $v); 

    $stmt = $mysqli->prepare("SELECT POSITION.ID, POSITION.Description FROM POSITION WHERE position.User = ? AND position.Owner IN (SELECT voter.ID FROM voter WHERE voter.Identifier != ?)");
    
    $u = $session->get('u');  
    $v = Cookie::get('v', null); 
    $stmt->bind_param("ss", $u, $v);

    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($IDs, $Descriptions);

    $arr = array();
    while ($stmt->fetch()) {
      $obj = array( 'ID' => $IDs,'Description' => $Descriptions);
      array_push($arr, $obj);
    }

    $arr = json_encode($arr);
    Cookie::set('p', $arr);
    $ranking = json_decode($arr);

    $stmt->close();
    $mysqli->close();
  }

  // pass $articles and $pagination to the template
  return [
    'voters' => $voters,
    'options' => $options
  ];

};