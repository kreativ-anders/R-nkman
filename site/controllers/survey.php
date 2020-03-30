<?php

return function ($kirby) {

  $ranking = null;
  $session = $kirby->session();
  $arr = array();

  if ($kirby->request()->is('POST') && get('ranking') && get('description') && get('nickname')) {
    $ranking = get('ranking');
    $desc = get('description');
    $nickname = get('nickname');

    if (Cookie::get('n') != $nickname) {
      Cookie::set('update', false);
    }

    Cookie::set('n', $nickname, ['lifetime' => time() +2592000]);  

    $l = count($ranking);

    $arr = array();

    for ($i=0; $i<$l; $i++) {
      $obj = array( 'ID' => $ranking[$i],'Description' => $desc[$i]);
      array_push($arr, $obj);
    }
    
    $arr = json_encode($arr);
    Cookie::set('p', $arr, ['lifetime' => time() +2592000]);
    $ranking = json_decode($arr);

    $u = $session->get('u');
    $v = $session->get('v');
    $n = Cookie::get('n', null);
    $l = count($ranking);
    $i = 0;   
    
    if (Cookie::get('update', false)) {

      foreach ($ranking as $position) {
        $r = $l-$i;

        $update = Db::update('result', [
          'User'      => $u,
          'Nickname'  => $n,
          'Vote'     => $v,
          'Position'  => $position->ID,
          'Rank'      => $r      
        ], [
          'User'      => $u,
          'Nickname'  => $n,
          'Vote'      => $v,
          'Position'  => $position->ID,
        ]);

        $i++;
        printf("UPDATE result (User, Nickname, Vote, Position, Rank) VALUES (%d, %s, %s, %d, %d): %b<br />\n", $u, $n, $v, $position->ID, $r, $update);
        
      }
      
      Cookie::set('update', true, ['lifetime' => time() +2592000]);
    }
    elseif (Cookie::get('insert', true) or Cookie::get('update') == false) {

      foreach ($ranking as $position) {
        $r = $l-$i;

        $id = Db::insert('result', [
          'User'      => $u,
          'Nickname'  => $n,
          'Vote'     => $v,
          'Position'  => $position->ID,
          'Rank'      => $r
        ]);

        $i++;
        printf("INSERT result (User, Nickname, Vote, Position, Rank) VALUES (%d, %s, %s, %d, %d); %d<br />\n", $u, $n, $v, $position->ID, $r, $id);
        
      }
      
      Cookie::set('insert', false, ['lifetime' => time() +2592000]);
      Cookie::set('update', true, ['lifetime' => time() +2592000]);
    }
  } 
  elseif (Cookie::exists('p')) {
    printf("Cookie is there");
    $ranking = json_decode(Cookie::get('p'));
  } 
  elseif (!Cookie::exists('u')) {
    return go('/');
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

    $options = Db::select('position', ['ID', 'Description'], 'User='. $u . ' and Owner !=' . $v);

    foreach ($options as $option) {
      $obj = array('ID' => $option->ID(), 'Description' => $option->Description());
      array_push($arr, (array) $obj); 
      //printf("ID= %s |  Description = %s<br />\n", $option->ID(), $option->Description());
    }

  
    $arr = json_encode($arr);
    Cookie::set('p', $arr);
    $ranking = json_decode($arr);

//--------------------------------
$mysqli->close();
  }
  // pass $articles and $pagination to the template
  return [
    'ranking' => $ranking
  ];

};