<?php 
  class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Category Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB
    public function __construct($db){
      $this->conn = $db;
    }

    // Get Categories
    public function read() {

      $createTableQuery = '
      CREATE TABLE IF NOT EXISTS `'. $this->table .'` (
        id INT AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        created_at DATE,  
        PRIMARY KEY (id)
      )  ENGINE=INNODB;
      ';

      $createTableStmt = $this->conn->prepare($createTableQuery);

      $createTableStmt->execute();

      // Create query
      $query = '
      SELECT 
        name, 
        id, 
        created_at
      FROM
        '. $this->table .'
      ORDER BY
        created_at
      ';

      // Prepared statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Category
    public function read_single() {


      // Create query
      $query = '
      SELECT
        id, 
        name, 
        created_at
      FROM
        '. $this->table .'
      WHERE
        id = ?
      LIMIT 0,1 
      ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set the properties
      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->created_at = $row['created_at'];
    }

    // Create new Category
    public function create() {
      

      // create query
      $query = '
      INSERT INTO 
      ' . $this->table .'
      SET
        name = :name 
      ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);
      
      // Clean up data
      $this->name = htmlspecialchars(strip_tags($this->name));
            
      // Bind Data
      $stmt->bindParam(':name', $this->name);
      
      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print Error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Category
    public function update() {
      // Create query
      $query = '
      UPDATE 
      ' . $this->table .'
      SET
        name =:name
      WHERE
        id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);
      
      // Clean up data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->id = htmlspecialchars(strip_tags($this->id));
      

      // Bind Data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':id', $this->id);
      
      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print Error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Delete Category 
    public function delete() {
      // Create query
      $query = '
      DELETE FROM 
      ' . $this->table .'
      WHERE
        id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);
      
      // Clean up data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind Data
      $stmt->bindParam(':id', $this->id);
      
      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print Error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }

?>