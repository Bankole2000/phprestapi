<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, Access-Control-Allow-Methods, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // SET ID to delete
  $post->id = $data->id;

  // Delete Post
  if($post->delete()) {
    echo json_encode(
      array('message' => 'Post with ID '. $post->id .' Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Deleted')
    );
  }

?>