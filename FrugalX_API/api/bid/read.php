<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Bid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog bid object
  $bid = new Bid($db);

  // Blog bid query
  $result = $bid->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any bids
  if($num > 0) {
    // bid array
    // $bids_arr = array();
     $bids_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);


      $bid_item = array(
        'id' => $id,
        'user' => $user,
        'bidAmount' => $bidAmount,
        'comment' => $comment,
        'avatarDir' => $avatarDir
      );

      // Push to "data"
      // array_push($bids_arr, $bid_item);
       array_push($bids_arr['data'], $bid_item);
    }

    // Turn to JSON & output
    echo json_encode($bids_arr);

  } else {
    // No bids
    echo json_encode(
      array('message' => 'No bids Found')
    );
  }
