<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json, image/webp');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $post->title = $data->title;
  $post->description = $data->description;
  $post->user = $data->user;
  $post->category = $data->category;
  $post->location = $data->location;
  $post->imageDir = $data->imageDir;
  $post->size = $data->size;
  $post->bidAsk = $data->bidAsk;
  $post->comment = $data->comment;
  $post->bidAmount = $data->bidAmount;
  $post->avatarDir = $data->avatarDir;

  // Create post
  if($post->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

