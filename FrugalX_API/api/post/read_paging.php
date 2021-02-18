<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../../config/core.php';
include_once '../../shared/utilities.php';
include_once '../../config/database.php';
include_once '../../models/post.php';
  
// utilities
$utilities = new Utilities();
  
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();
  
// initialize object
$post = new Post($db);
  
// query products
$stmt = $post->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $posts_arr=array();
    $posts_arr["records"]=array();
    $posts_arr["paging"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $post_arr=array(
            "id" => $id,
            "user" => $user,
            "description" => $description,
            "size" => $size,
            "category" => $category,
            "imageDir" => $imageDir,
            "title" => $title,
            'location' => $location,
            'bidAsk' => $bidAsk,
            'bidAmount' => $bidAmount,
            'comment' => $comment,
            'avatarDir' => $avatarDir
        );
  
        array_push($posts_arr["records"], $post_arr);
    }
  
  
    // include paging
    $total_rows=$post->count();
    $page_url="{$home_url}post/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $posts_arr["paging"]=$paging;
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($posts_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user products does not exist
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>