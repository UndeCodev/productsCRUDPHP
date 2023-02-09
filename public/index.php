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
          if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_FILES['image'])) { 

            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];

            if (is_uploaded_file($image_tmp)) {
                $destination = "../assets/img/" . $image_name;
                move_uploaded_file($image_tmp, $destination);
            }

            $created = $productDao->createProduct($_POST['name'], $_POST['description'], $_POST['price'], $image_name);
            
            echo json_encode($created); 
          }

          break;
        case 'PUT':
          
          function getValue($property, $rawData) {
            preg_match("/Content-Disposition: form-data; name=\"$property\"\r\n\r\n(.+)\r\n/", $rawData, $matches);
            return $matches[1];
          }

          $rawData = file_get_contents("php://input");
          
          $id = getValue("id", $rawData);
          $name = getValue("name", $rawData);
          $description = getValue("description", $rawData);
          $price = getValue("price", $rawData);
          
          if(isset($id) && isset($name) && isset($description) && isset($price)){
            $updated = $productDao->updateProduct($id, $name, $description, $price);

            echo json_encode($updated);
          }
          
          break;
        case 'DELETE':
            
          if (isset($_GET['id'])) {
            $deleted = $productDao->deleteProduct($_GET['id']);
            
            echo json_encode($deleted);
          }

          break;
        default:
          $response = array('message' => 'Invalid request method');
          echo json_encode($response);
          break;
      }
      
    $db->close();
?>