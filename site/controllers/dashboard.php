<?php

return function ($kirby) {

  if (!$kirby->user()) {
    go('/');
  }

  $vid = null;
  $voter = null;
  $session = $kirby->session();
  $arr = array();

  $ranking = null;

  $mysqli = new mysqli( option('db')["host"]
                       ,option('db')["user"]
                       ,option('db')["password"]
                       ,option('db')["database"]);

  $session = $kirby->session();

  $u = Db::min('user', 'ID', 'Identifier="'. $kirby->user() . '"');
  $v = Db::min('voter', 'ID', 'Identifier="'. Cookie::get('v') . '"');

  $session->set('u', $u); 
  $session->set('v', $v); 

  mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("SELECT POSITION.Description, sum(RESULT.Rank) as Score from result INNER JOIN POSITION on POSITION.ID = RESULT.Position WHERE RESULT.User = ? GROUP BY RESULT.Position ORDER BY sum(RESULT.Rank) DESC")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $u);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($Descriptions, $Scores);

    while ($stmt->fetch()) {
      //printf("Desc: %s | Score: %s", $Descriptions, $Scores);
      $obj = array('Description' => $Descriptions, 'Score' => $Scores);
      array_push($arr, (array) $obj);
    }
  
    $arr = json_encode($arr);
    $ranking = json_decode($arr);

    /* close statement */
    $stmt->close();
}

  $mysqli->close();
  
  return [
    'ranking' => $ranking
  ];

};