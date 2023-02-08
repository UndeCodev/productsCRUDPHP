<?php 

    class ProductDao {
        private $conn;

        public function __construct($conn) {
          $this->conn = $conn;
        }
    
        public function getAllProducts(){
          $query = "SELECT * FROM products";
          return $this->conn->query($query);
        }

        public function getProduct($id) {
          $query = "SELECT * FROM products WHERE id = '$id'";
          return $this->conn->query($query);
        }
    
        public function createProduct($name, $description, $price, $image_name) {
          $query = "INSERT INTO products (name, description, price, ImageURL) VALUES ('$name', '$description', '$price', '$image_name')";
          return $this->conn->query($query);
        }
    
        public function updateProduct($id, $name, $description, $price) {
          $query = "UPDATE products SET name = '$name', description = '$description', price = '$price' WHERE id = '$id'";
          return $this->conn->query($query);
        }
    
        public function deleteProduct($id) {
          $query = "DELETE FROM products WHERE id = '$id'";
          return $this->conn->query($query);
        }
    }

?>