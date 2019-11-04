<?php

return function ($kirby) {

  $vid = null;
  $voter = null;
  $session = $kirby->session();
  $arr = array();

  $ranking = null;

  $mysqli = new mysqli("localhost", "u204246837_rankman_user", "123456", "u204246837_rankman_db");

  $session = $kirby->session();
  $u = Db::min('user', 'ID', 'Identifier="'. Cookie::get('u') . '"');
  $v = Db::min('voter', 'ID', 'Identifier="'. Cookie::get('v') . '"');
  $session->set('u', $u); 
  $session->set('v', $v); 
// --------------------
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$stmt =  $mysqli->stmt_init();
  if ($stmt->prepare("SELECT POSITION.Description, sum(RESULT.Rank) as Score from result INNER JOIN POSITION on POSITION.ID = RESULT.Position WHERE RESULT.User = ? GROUP BY RESULT.Position ORDER BY sum(RESULT.Rank) DESC")) {

    /* bind parameters for markers */
    $u = $session->get('u');  
    $stmt->bind_param("s", $u);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($Descriptions, $Scores);

    /* fetch value */
    $stmt->fetch();

    while ($stmt->fetch()) {
      $obj = array('Description' => $Descriptions, 'Score' => $Scores);
      array_push($arr, (array) $obj);
    }
  
  
    $arr = json_encode($arr);
    $ranking = json_decode($arr);

    /* close statement */
    $stmt->close();
}
//--------------------------------
 // $stmt = $mysqli->prepare("SELECT POSITION.Description, sum(RESULT.Rank) as Score from result INNER JOIN POSITION on POSITION.ID = RESULT.Position WHERE RESULT.User = ? GROUP BY RESULT.Position ORDER BY sum(RESULT.Rank) DESC");

  
  //$u = $session->get('u');  
  //$stmt->bind_param("s", $u);

  //$ranking = Db::select('survey_result', '*', ['User' => $u]);

  
  //$stmt->execute();

  /* bind result variables */
  //$stmt->bind_result($Descriptions, $Scores);

  
  /*while ($stmt->fetch()) {
    $obj = array( 'Description' => $Descriptions,'Score' => $Scores);
    array_push($arr, $obj);
  }


  $arr = json_encode($arr);
  $ranking = json_decode($arr);
*/

  //$stmt->close();
  $mysqli->close();
  

  // pass $articles and $pagination to the template
  return [
    'ranking' => $ranking
  ];

};