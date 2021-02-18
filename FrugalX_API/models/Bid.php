<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $user;
    public $comment;
    public $bidAmount;
    public $avatarDir;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM ' . $this->table . '
                                    WHERE
                                      id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->user = $row['user'];
          $this->comment = $row['comment'];
          $this->bidAmount = $row['bidAmount'];
          $this->avatarDir = $row['avatarDir'];
    }

    // Get posts with pagination
    public function readPaging($from_record_num, $records_per_page) {
      // Select query
      $query = 'SELECT * FROM ' . $this->table . ' LIMIT ?, ?';

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind variable values
      $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
      $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

      // Execute query
      $stmt->execute();

      // return values from database
      return $stmt;
}

      // used for paging products
    public function count(){
      $query = "SELECT COUNT(*) as total_rows FROM " . $this->table . "";

      $stmt = $this->conn->prepare( $query );
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      return $row['total_rows'];
    }

    // Create Post
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' 
            SET  
              user = :user, 
              avatarDir = :avatarDir
              bidAmount = :bidAmount';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->user = htmlspecialchars(strip_tags($this->user));
          $this->avatarDir = htmlspecialchars(strip_tags($this->avatarDir));
          $this->comment = htmlspecialchars(strip_tags($this->comment));
          $this->bidAmount = htmlspecialchars(strip_tags($this->bidAmount));
          // Bind data
          $stmt->bindParam(':user', $this->user);
          $stmt->bindParam(':bidAmount', $this->bidAmount);
          $stmt->bindParam(':comment', $this->comment);
          $stmt->bindParam(':avatarDir', $this->avatarDir);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET 
                                    user = :user, 
                                    comment = :comment, 
                                    avatarDir = :avatarDir, 
                                    bidAmount = :bidAmount
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->user = htmlspecialchars(strip_tags($this->user));
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->comment = htmlspecialchars(strip_tags($this->comment));
          $this->bidAmount = htmlspecialchars(strip_tags($this->bidAmount));
          $this->avatarDir = htmlspecialchars(strip_tags($this->avatarDir));

          // Bind data
          $stmt->bindParam(':user', $this->user);
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':avatarDir', $this->avatarDir);
          $stmt->bindParam(':comment', $this->comment);
          $stmt->bindParam(':bidAmount', $this->bidAmount);


          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }