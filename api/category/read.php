<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  
  // Instantiate DB $ connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Category object
  $category = new Category($db);

  // Categories query
  $result = $category->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $categories_arr = array();
    $categories_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $category_item = array(
        'id' => $id, 
        'name' => $name,  
        'created_at' => $created_at
      );

      // Push to "data"
      // array_push($posts_arr, $post_item);
      array_push($categories_arr['data'], $category_item);
    }
    // Turn to JSON
    echo json_encode($categories_arr);
  } else {
    // No Posts
    echo json_encode(array('message' => 'No Categories found'));
  }

?>