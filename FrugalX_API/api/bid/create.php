<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json, image/webp');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Bid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog bid object
  $bid = new Bid($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $bid->user = $data->user;
  $bid->comment = $data->comment;
  $bid->bidAmount = $data->bidAmount;
  $bid->avatarDir = $data->avatarDir;

  // Create bid
  if($bid->create()) {
    echo json_encode(
      array('message' => 'Bid Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Bid Not Created')
    );
  }

