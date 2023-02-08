<?php 
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE,   OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once '../clasess/database/DBConnection.php';
    require_once '../clasess/dao/ProductDAO.php';

    // Instances -> Database and ProductDAO (CRUD methods)
    $db = new DBConnection();    
    $productDao = new ProductDao($db);

    // Verify what action we are going to perform
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            
          if (isset($_GET['allProducts'])) {
            $products = $productDao->getAllProducts();
            
            printf(json_encode($products->fetch_all(MYSQLI_ASSOC), JSON_UNESCAPED_UNICODE));
          }
          
          break;
        case 'POST':
          
          // parse_str(file_get_contents("php://input"), $data);
          // $name = $put_vars["name"];
          // $name = $data["name"];
          // $description = $data["description"];

          // if(isset($name)){
          //   echo json_encode('success');
          // }
          echo json_encode(); 

          // if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_FILES['image'])) { 

          //   $image_name = $_FILES['image']['name'];
          //   $image_tmp = $_FILES['image']['tmp_name'];

          //   if (is_uploaded_file($image_tmp)) {
          //       $destination = "../assets/img/" . $image_name;
          //       move_uploaded_file($image_tmp, $destination);
          //   }

          //   $created = $productDao->createProduct($_POST['name'], $_POST['description'], $_POST['price'], $image_name);
            
          //   $response = array('messsage' => (($created) ? 'Product created successfully' : 'Failed to create product'));

          //   echo json_encode($response); 
          // }

          break;
        case 'PUT':
          
          parse_str(file_get_contents("php://input"), $put_vars);
          
          if (isset($put_vars['id']) && isset($put_vars['name']) && isset($put_vars['description']) && isset($put_vars['price'])) {
            $updated = $productDao->updateProduct($put_vars['id'], $put_vars['name'], $put_vars['description'], $put_vars['price']);
            
            $response = array('messsage' => (($updated) ? 'Product updated successfully' : 'Failed to update product'));
            echo json_encode($response); 
          }
          
          break;
        case 'DELETE':
            
          parse_str(file_get_contents("php://input"), $delete_vars);
          
          if (isset($delete_vars['id'])) {
            $deleted = $productDao->deleteProduct($delete_vars['id']);
            
            $response = array('messsage' => (($deleted) ? 'Product deleted successfully' : 'Failed to delete product'));
            echo json_encode($response); 
          }

          break;
        default:
          $response = array('message' => 'Invalid request method');
          echo json_encode($response);
          break;
      }
      
    $db->close();
?>