<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, Access-Control-Allow-Methods, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // SET ID to update
  $category->id = $data->id;

  // Requirements in the Body.
  $category->name = $data->name;

  // Update category
  if($category->update()) {
    echo json_encode(
      array('message' => 'category with ID '. $category->id .' Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'category Not Updated')
    );
  }

?>