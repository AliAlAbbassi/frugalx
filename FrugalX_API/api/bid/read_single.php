<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Bid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate content bid object
  $bid = new Bid($db);

  // Get ID
  $bid->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get bid
  $bid->read_single();

  // Create array
  $bid_arr = array(
    'id' => $bid->id,
    'user' => $bid->user,
    'bidAmount' => $bid->bidAmount,
    'avatarDir' => $avatarDir,
    'comment' => $comment 
  );

  // Make JSON
  print_r(json_encode($bid_arr));