<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category;
    public $user;
    public $title;
    public $description;
    public $imageDir;
    public $imageObj;
    public $created_at;
    public $size;
    public $location;
    public $bidAsk;
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
          $query = 'SELECT P.id,
                           P.title,
                           P.size,
                           P.location,
                           P.category,
                           P.description,
                           P.user,
                           P.imageDir,
                           P.created_at,
                           P.bidAsk,
                           B.user_bids,
                           B.bidAmount,
                           B.avatarDir,
                           B.comment
                            FROM ' . $this->table . ' P
                                JOIN bids B ON B.id = P.id
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
          $this->title = $row['title'];
          $this->user = $row['user'];
          $this->imageDir = $row['imageDir'];
          $this->description = $row['description'];
          $this->category = $row['category'];
          $this->size = $row['size'];
          $this->bidAsk = $row['bidAsk'];
          $this->location = $row['location'];
          $this->comment = $row['comment'];
          $this->bidAmount = $row['bidAmount'];
          $this->avatarDir = $row['avatarDir'];
    }

    // Get posts with pagination
    public function readPaging($from_record_num, $records_per_page) {
      // Select query
      $query = 'SELECT P.id, 
                       P.title,
                       P.size,
                       P.location,
                       P.category,
                       P.description,
                       P.user,
                       P.imageDir,
                       P.created_At,
                       P.bidAsk,
                       B.user_bids,
                       B.bidAmount,
                       B.avatarDir,
                       B.comment 
                            FROM ' . $this->table . 'P 
                            JOIN bids B ON B.id = P.id
                            LIMIT ?, ?';

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
      $query = "SELECT COUNT(P.id, 
                             P.title, 
                             P.size, 
                             P.location, 
                             P.category, 
                             P.description, 
                             P.user, 
                             P.imageDir,
                             P.created_at,
                             P.bidAsk,
                             B.user_bids,
                             B.bidAmount,
                             B.avatarDir,
                             B.comment,
                             B.id) as total_rows FROM " . $this->table . "P JOIN bids B ON B.id = P.id";

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
              title = :title, 
              user = :user, 
              imageDir = :imageDir, 
              category = :category, 
              description = :description, 
              size = :size, 
              bidAsk = :bidAsk, 
              location = :location';

            $query2 = 'INSERT INTO bids 
                SET 
                  bidAmount = :bidAmount, 
                  comment = :comment, 
                  avatarDir = :avatarDir, 
                  user_bids = :user_bids';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          $stmt2 = $this->conn->prepare($query2);

          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->description = htmlspecialchars(strip_tags($this->description));
          $this->user = htmlspecialchars(strip_tags($this->user));
          $this->category = htmlspecialchars(strip_tags($this->category));
          $this->imageDir = htmlspecialchars(strip_tags($this->imageDir));
          $this->size = htmlspecialchars(strip_tags($this->size));
          $this->bidAsk = htmlspecialchars(strip_tags($this->bidAsk));
          $this->location = htmlspecialchars(strip_tags($this->location));
          $this->avatarDir = htmlspecialchars(strip_tags($this->avatarDir));
          $this->comment = htmlspecialchars(strip_tags($this->comment));
          $this->bidAmount = htmlspecialchars(strip_tags($this->bidAmount));

          // Bind data for query 1
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':description', $this->description);
          $stmt->bindParam(':user', $this->user);
          $stmt->bindParam(':category', $this->category);
          $stmt->bindParam(':imageDir', $this->imageDir);
          $stmt->bindParam(':size', $this->size);
          $stmt->bindParam(':bidAsk', $this->bidAsk);
          $stmt->bindParam(':location', $this->location);

          // bind data for query 2
          $stmt2->bindParam(':avatarDir', $this->avatarDir);
          $stmt2->bindParam(':comment', $this->comment);
          $stmt2->bindParam(':bidAmount', $this->bidAmount);

          // Execute query 1
          if($stmt->execute()) {
            return true;
      }
          // Execute query 2
          if($stmt2->execute()) {
            return true;
      }

      // Print error if something goes wrong 1
      printf("Error: %s.\n", $stmt->error);

      // Print error if something goes wrong 2
      printf("Error: %s.\n", $stmt2->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query 1
          $query = 'UPDATE ' . $this->table . '
                                SET 
                                  title = :title, 
                                  user = :user, 
                                  imageDir = :imageDir, 
                                  category = :category, 
                                  description = :description, 
                                  size = :size, 
                                  bidAsk = :bidAsk, 
                                  location = :location, 
                                WHERE id = :id';
          //Create query 2
          $query2 = 'UPDATE bids 
                                SET
                                  comment = :comment, 
                                  avatarDir = :avatarDir, 
                                  bidAmount = :bidAmount';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          $stmt2 = $this->conn->prepare($query2);

          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->description = htmlspecialchars(strip_tags($this->description));
          $this->user = htmlspecialchars(strip_tags($this->user));
          $this->category = htmlspecialchars(strip_tags($this->category));
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->size = htmlspecialchars(strip_tags($this->size));
          $this->imageDir = htmlspecialchars(strip_tags($this->imageDir));
          $this->bidAsk = htmlspecialchars(strip_tags($this->bidAsk));
          $this->location = htmlspecialchars(strip_tags($this->location));
          $this->comment = htmlspecialchars(strip_tags($this->comment));
          $this->bidAmount = htmlspecialchars(strip_tags($this->bidAmount));
          $this->avatarDir = htmlspecialchars(strip_tags($this->avatarDir));

          // Bind data
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':description', $this->description);
          $stmt->bindParam(':user', $this->user);
          $stmt->bindParam(':category', $this->category);
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':imageDir', $this->imageDir);
          $stmt->bindParam(':size', $this->size);
          $stmt->bindParam(':bidAsk', $this->bidAsk);
          $stmt->bindParam(':location', $this->location);
          
          // Bind data for query 2
          $stmt2->bindParam(':avatarDir', $this->avatarDir);
          $stmt2->bindParam(':comment', $this->comment);
          $stmt2->bindParam(':bidAmount', $this->bidAmount);


          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Execute query
          if($stmt2->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          printf("Error: %s.\n", $stmt2->error);

          return false;
    }

    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
          $query2 = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          $stmt2 = $this->conn->prepare($query2);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);
          $stmt2->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }
          // Execute query
          if($stmt2->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          printf("Error: %s.\n", $stmt2->error);

          return false;
    }
    
  }