<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Bid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog bid object
  $bid = new Bid($db);

  // Get raw bided data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $bid->id = $data->id;

  // Delete bid
  if($bid->delete()) {
    echo json_encode(
      array('message' => 'bid Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'bid Not Deleted')
    );
  }

