<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Bid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog Bid object
  $bid = new Bid($db);

  // Get raw Bided data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $bid->id = $data->id;

  $bid->user = $data->user;
  $bid->bidAmount = $data->bidAmount;
  $bid->comment = $data->comment;
  $bid->avatarDir = $data->avatarDir;

  // Update bid
  if($bid->update()) {
    echo json_encode(
      array('message' => 'bid Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'bid Not Updated')
    );
  }

