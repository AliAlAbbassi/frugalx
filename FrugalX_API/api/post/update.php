<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
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

  // Set ID to update
  $post->id = $data->id;

  $post->title = $data->title;
  $post->description = $data->description;
  $post->user = $data->user;
  $post->category = $data->category;
  $post->size = $data->size;
  $post->imageDir = $data->imageDir;
  $post->location = $data->location;
  $post->bidAsk = $data->bidAsk;
  $post->bidAmount = $data->bidAmount;
  $post->comment = $data->comment;
  $post->avatarDir = $data->avatarDir;

  // Update post
  if($post->update()) {
    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }

